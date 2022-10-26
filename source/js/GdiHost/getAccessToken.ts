const { modMyPages: { restUrl } } = window;

export const getAccessToken = () : Promise<string> => 
    fetch(`${restUrl}mod-my-pages/v1/access-token`)
        .then(r => r.json());

export default getAccessToken;