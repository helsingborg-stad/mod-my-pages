const { modMyPages: { restUrl } } = window;

export type AccessTokenResponse = {
    token: string,
    expires: number
}

export const getAccessToken = (): Promise<AccessTokenResponse> =>
    fetch(`${restUrl}mod-my-pages/v1/access-token`, { method: 'POST' })
        .then(r => r.json())
        .then(({ token, expires }) => ({
            token: token ?? '',
            expires: expires ?? 0
        }));
