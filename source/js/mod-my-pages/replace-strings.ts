export const replaceStrings = async (
  selector: string,
  stringsToReplace: Record<string, string>,
) => {
  [...document.querySelectorAll(selector)].forEach((element) => {
    [...Object.entries(stringsToReplace)]
      .map(([search, value]) => ({
        search: `{user.${search}}`,
        value,
      }))
      .forEach(({ search, value }) => {
        element.innerHTML = element.innerHTML.replace(
          new RegExp(search, 'g'),
          value,
        );
      });
  });
};
