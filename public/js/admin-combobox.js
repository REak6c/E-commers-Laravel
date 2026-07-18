/**
 * admin-combobox.js  v3
 *
 * Portal pattern: the dropdown panel is appended to <body> so it is never
 * clipped by overflow:hidden on ancestor cards. JS positions it against the
 * trigger's bounding rect on every open + scroll/resize.
 */
(function () {
    'use strict';

    function initCombobox(wrap) {
        if (wrap.__admCbInit) return;
        wrap.__admCbInit = true;

        var id         = wrap.dataset.cbId;
        var trigger    = wrap.querySelector('.adm-combobox__trigger');
        var panel      = wrap.querySelector('.adm-combobox__panel');
        var search     = panel ? panel.querySelector('.adm-combobox__search') : null;
        var optionsEl  = panel ? panel.querySelector('.adm-combobox__options') : null;
        var emptyEl    = panel ? panel.querySelector('.adm-combobox__empty')   : null;
        var valueInput = document.getElementById(wrap.dataset.valueInput);

        if (!trigger || !panel || !search || !optionsEl) return;

        // ── Portal: move panel to <body> ───────────────────────────
        document.body.appendChild(panel);
        panel.style.position = 'fixed';
        panel.style.zIndex   = '9999';
        panel.hidden         = true;

        // ── Options ────────────────────────────────────────────────
        var options       = (window.__cbOpts && window.__cbOpts[id]) ? window.__cbOpts[id] : [];
        var isOpen        = false;
        var selectedValue = valueInput ? valueInput.value : '';
        var focusedIndex  = -1;

        // ── Position panel under the trigger ──────────────────────
        function positionPanel() {
            var r = trigger.getBoundingClientRect();
            panel.style.left  = r.left  + 'px';
            panel.style.top   = (r.bottom + 4) + 'px';
            panel.style.width = r.width + 'px';
        }

        // ── Render options ─────────────────────────────────────────
        function getFiltered(query) {
            var q = query.trim().toLowerCase();
            if (!q) return options;
            return options.filter(function (o) {
                return o.label.toLowerCase().indexOf(q) !== -1;
            });
        }

        function renderOptions(query) {
            var filtered = getFiltered(query || '');
            optionsEl.innerHTML = '';
            focusedIndex = -1;

            filtered.forEach(function (opt, idx) {
                var el = document.createElement('div');
                el.className = 'adm-combobox__option';
                el.setAttribute('role', 'option');
                el.setAttribute('data-value', opt.value);

                if (opt.value === selectedValue) {
                    el.classList.add('adm-combobox__option--active');
                    el.setAttribute('aria-selected', 'true');
                    focusedIndex = idx;
                } else {
                    el.setAttribute('aria-selected', 'false');
                }

                el.textContent = opt.label;
                // mousedown prevents blur on trigger before click fires
                el.addEventListener('mousedown', function (e) { e.preventDefault(); });
                el.addEventListener('click', function () { selectOption(opt); });
                optionsEl.appendChild(el);
            });

            if (emptyEl) emptyEl.hidden = filtered.length > 0;
        }

        // ── Select ─────────────────────────────────────────────────
        function selectOption(opt) {
            selectedValue = opt.value;

            if (valueInput) {
                valueInput.value = opt.value;
                valueInput.dispatchEvent(new Event('change', { bubbles: true }));
            }

            var labelEl = trigger.querySelector('.adm-combobox__label');
            if (labelEl) {
                labelEl.textContent = opt.label;
                labelEl.classList.remove('adm-combobox__label--placeholder');
            }

            trigger.classList.remove('is-invalid');
            trigger.removeAttribute('aria-invalid');

            closePanel();
        }

        // ── Open / close ───────────────────────────────────────────
        function openPanel() {
            if (isOpen) return;
            isOpen = true;

            positionPanel();
            panel.hidden = false;
            wrap.classList.add('adm-combobox--open');
            trigger.setAttribute('aria-expanded', 'true');

            search.value = '';
            renderOptions('');

            requestAnimationFrame(function () {
                search.focus();
                var active = optionsEl.querySelector('.adm-combobox__option--active');
                if (active) active.scrollIntoView({ block: 'nearest' });
            });

            document.addEventListener('click',  onOutside, true);
            document.addEventListener('keydown', onKey,     true);
            window.addEventListener('scroll',   onScroll,  true);
            window.addEventListener('resize',   onResize);
        }

        function closePanel() {
            if (!isOpen) return;
            isOpen = false;

            panel.hidden = true;
            wrap.classList.remove('adm-combobox--open');
            trigger.setAttribute('aria-expanded', 'false');

            document.removeEventListener('click',  onOutside, true);
            document.removeEventListener('keydown', onKey,     true);
            window.removeEventListener('scroll',   onScroll,  true);
            window.removeEventListener('resize',   onResize);
        }

        // ── Event handlers ─────────────────────────────────────────
        function onOutside(e) {
            // clicks inside the panel (now on body) or the trigger are fine
            if (wrap.contains(e.target) || panel.contains(e.target)) return;
            closePanel();
        }

        function onScroll() { positionPanel(); }
        function onResize()  { positionPanel(); }

        function onKey(e) {
            var items = optionsEl.querySelectorAll('.adm-combobox__option');
            var total = items.length;

            switch (e.key) {
                case 'Escape':
                    e.preventDefault();
                    closePanel();
                    trigger.focus();
                    break;

                case 'ArrowDown':
                    e.preventDefault();
                    if (!total) break;
                    focusedIndex = (focusedIndex + 1) % total;
                    highlightIndex(items, focusedIndex);
                    break;

                case 'ArrowUp':
                    e.preventDefault();
                    if (!total) break;
                    focusedIndex = (focusedIndex - 1 + total) % total;
                    highlightIndex(items, focusedIndex);
                    break;

                case 'Enter':
                case ' ':
                    if (document.activeElement === search) break;
                    e.preventDefault();
                    if (focusedIndex >= 0 && items[focusedIndex]) {
                        var val = items[focusedIndex].dataset.value;
                        var found = options.find(function (o) { return o.value === val; });
                        if (found) selectOption(found);
                    }
                    break;

                case 'Tab':
                    closePanel();
                    break;
            }
        }

        function highlightIndex(items, idx) {
            items.forEach(function (el, i) {
                if (i === idx) {
                    el.classList.add('adm-combobox__option--active');
                    el.scrollIntoView({ block: 'nearest' });
                } else {
                    el.classList.remove('adm-combobox__option--active');
                }
            });
        }

        search.addEventListener('input', function () { renderOptions(search.value); });

        trigger.addEventListener('click', function () {
            isOpen ? closePanel() : openPanel();
        });

        trigger.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ' || e.key === 'ArrowDown') {
                e.preventDefault();
                openPanel();
            }
        });
    }

    // ── Boot ───────────────────────────────────────────────────────
    function initWithin(root) {
        var scope = (root && root.querySelectorAll) ? root : document;
        if (scope.matches && scope.matches('.adm-combobox')) initCombobox(scope);
        scope.querySelectorAll('.adm-combobox').forEach(initCombobox);
    }

    function observe() {
        if (typeof MutationObserver === 'undefined' || !document.body) return;
        new MutationObserver(function (mutations) {
            mutations.forEach(function (m) {
                m.addedNodes.forEach(function (node) {
                    if (node.nodeType !== 1) return;
                    initWithin(node);
                });
            });
        }).observe(document.body, { childList: true, subtree: true });
    }

    window.initAdminComboboxes = initWithin;

    function boot() { initWithin(document); observe(); }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
