/* =====================================================================
   Admin Select enhancer
   Upgrades native <select> form controls into themed Tom Select dropdowns
   (native <select> panels can't be styled). Applies across the whole back
   office (admin + vendor), including DataTables "Show N entries" menus.
   Progressive enhancement: if Tom Select fails to load, the plain
   <select> keeps working.

   Enhanced:  select.admin-select, select.form-select, select.form-control,
              and DataTables length menus (.dt-length / .dataTables_length)
   Skipped:   [data-no-enhance], already-enhanced
   Dynamic:   a MutationObserver enhances selects injected after load
              (cloned variant rows, DataTables length menu, AJAX partials)
   ===================================================================== */
(function () {
    'use strict';

    var ENHANCE_MATCH = '.admin-select, .form-select, .form-control';
    // DataTables "Show N entries" menu (v1: .dataTables_length, v2: .dt-length).
    var LENGTH_CONTAINER = '.dt-length, .dataTables_length';

    function isLengthMenu(el) {
        return !!el.closest(LENGTH_CONTAINER);
    }

    function shouldEnhance(el) {
        if (!el || el.tagName !== 'SELECT') return false;
        if (el.tomselect || el.dataset.tsInit === '1') return false;
        if (el.matches('[data-no-enhance]')) return false;
        return el.matches(ENHANCE_MATCH) || isLengthMenu(el);
    }

    function resolvePlaceholder(el) {
        if (el.dataset.placeholder) {
            return el.dataset.placeholder;
        }
        // Fall back to a disabled/empty option's text (a pure placeholder).
        var opt = el.querySelector('option[value=""][disabled]') || el.querySelector('option[value=""]');
        return opt ? opt.textContent.trim() : null;
    }

    function shouldSearch(el) {
        var attr = el.getAttribute('data-search');
        if (attr === 'true') return true;
        if (attr === 'false') return false;
        // Auto: only offer type-to-filter on longer lists.
        return el.querySelectorAll('option').length > 8;
    }

    function enhance(el) {
        if (!shouldEnhance(el)) {
            return;
        }

        var lengthMenu = isLengthMenu(el);

        var settings = {
            create: false,
            allowEmptyOption: true,
            placeholder: lengthMenu ? null : resolvePlaceholder(el),
            // Preserve the original <option> order in the dropdown.
            sortField: [{ field: '$order' }],
            // No type-to-filter for the tiny length menu; auto for the rest.
            searchField: (!lengthMenu && shouldSearch(el)) ? ['text'] : [],
            maxOptions: null,
        };

        if (lengthMenu) {
            // Tom Select fires only an internal "change"; it does NOT emit a
            // native DOM change event. DataTables binds change.DT to its
            // length <select>, so re-dispatch a native change to drive it.
            settings.onChange = function () {
                el.dispatchEvent(new Event('change', { bubbles: true }));
            };
        }

        try {
            var ts = new TomSelect(el, settings);
            el.dataset.tsInit = '1';
            if (lengthMenu && ts && ts.wrapper) {
                ts.wrapper.classList.add('ts-length');
            }
        } catch (e) {
            // Leave the native <select> in place if enhancement fails.
            if (window.console) {
                console.warn('admin-select: enhancement skipped', e);
            }
        }
    }

    function enhanceWithin(root) {
        var scope = root && root.querySelectorAll ? root : document;
        if (scope.matches && scope.matches('select')) {
            enhance(scope);
        }
        scope.querySelectorAll('select').forEach(enhance);
    }

    function initAll(root) {
        if (typeof TomSelect === 'undefined') {
            return;
        }
        enhanceWithin(root || document);
    }

    // Watch for selects injected after page load (cloned variant rows,
    // DataTables length menus, AJAX partials) and enhance them automatically.
    function observe() {
        if (typeof MutationObserver === 'undefined' || !document.body) {
            return;
        }
        var observer = new MutationObserver(function (mutations) {
            if (typeof TomSelect === 'undefined') return;
            mutations.forEach(function (m) {
                m.addedNodes.forEach(function (node) {
                    if (node.nodeType !== 1) return; // elements only
                    enhanceWithin(node);
                });
            });
        });
        observer.observe(document.body, { childList: true, subtree: true });
    }

    // Expose so pages injecting selects can enhance on demand if needed.
    window.initAdminSelects = initAll;

    function boot() {
        initAll(document);
        observe();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
