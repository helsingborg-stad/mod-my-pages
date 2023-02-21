export const setBodyClass = (isAuthenticated: boolean) => {
  [...document.querySelectorAll('body')]
    .map((e) => ({
      classNames: [...e.classList],
      classList: e.classList,
      isAuthenticated,
    }))
    .forEach(
      ({ classNames, isAuthenticated, classList }) => (
        classNames.includes('is-authenticating') && classList.remove('is-authenticating'),
        isAuthenticated
          ? !classNames.includes('is-authenticated') && classList.toggle('is-authenticated')
          : !classNames.includes('not-authenticated') && classList.toggle('not-authenticated')
      ),
    );
};
