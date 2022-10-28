const { modMyPages: { restUrl } } = window;

export const getAccessToken = () : Promise<string> => 
    fetch(`${restUrl}mod-my-pages/v1/access-token`, {method: 'POST'})
        .then(r => r.json())
        .then(({ token } : { token: string; }) => token ?? '');

export default getAccessToken;