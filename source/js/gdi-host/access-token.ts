import { GetAccessTokenResponse } from './api';

const {
  modMyPages: { restUrl },
} = window;

export const getAccessToken = (): Promise<GetAccessTokenResponse> =>
  fetch(`${restUrl}mod-my-pages/v1/access-token`, { method: 'POST' })
    .then((r) => r.json())
    .then(({ token, expires }) => ({
      token: token ?? '',
      expires: expires ?? 0,
    }));
