const capitalizeFirstLetter = (str: string) =>
  str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();

const capitalizeWords = (str: any) =>
  typeof str === 'string'
    ? str.split(' ').map(capitalizeFirstLetter).join(' ')
    : str;

const normalizersByKey = {
  name: capitalizeWords,
  firstName: capitalizeWords,
  lastName: capitalizeWords,
} as Record<string, any>;

export const normalizeToken = (
  decoded: Record<string, string>,
): Record<string, string> =>
  Object.entries(decoded).reduce(
    (obj, [key, value]: [string, any]) => ({
      ...obj,
      [key]: Object.keys(normalizersByKey).includes(key)
        ? normalizersByKey[key](value)
        : value,
    }),
    {},
  );

export default normalizeToken;
