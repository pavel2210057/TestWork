const GlobalLang = function(prefix, storage_key) {
    const DEFAULT_LANG = "en";
    let lang_name, lang, cache = {};

    const setLang = async new_lang => {
        if (!cache[new_lang]) {
            const name = `/i18n/${prefix}/${new_lang}.json`;
            let res = await App.loadJSON(name);
            cache[new_lang] = lang = await res.json();
        }
        else
            lang = cache[new_lang];

        lang_name = new_lang;
        localStorage.setItem(storage_key, new_lang);
        return getLang();
    };

    const getCurrentLang = () => lang_name;

    const getLang = () => lang;

    return {
        init: async () => {
            lang_name = localStorage.getItem(storage_key);
            if (!lang_name)
                await setLang(DEFAULT_LANG);
            else
                await setLang(lang_name);
        },
        setLang: setLang,
        getCurrentLang: getCurrentLang,
        getLang: getLang
    };
};