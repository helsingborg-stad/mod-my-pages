export const triggerPressOnDomLoaded = () =>
  [...document.querySelectorAll('.js-press-on-dom-loaded')].forEach(
    (e: any) => e?.click && e.click(),
  );
