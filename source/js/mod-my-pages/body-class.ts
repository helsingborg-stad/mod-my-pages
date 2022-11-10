const { getAccessToken } = window.gdiHost;

export const setBodyClass = async () => {
    const { token } = await getAccessToken();

    [...document.querySelectorAll('body')]
        .map((e) => ({
            classNames: [...e.classList],
            classList: e.classList,
            isAuthenticated: token?.length > 0
        }))
        .filter(({ classNames, isAuthenticated }) =>
            isAuthenticated && !classNames.includes('is-authenticated')
        )
        .forEach(({ classList }) =>
            classList.toggle('is-authenticated')
        );
}