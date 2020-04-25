const App = (function(){
    const loadJSON = async url => fetch(url);

    const uploadJSON = async (url, data) => {
        const form_data = new FormData;
        for(let i in data)
            form_data.append(i, data[i]);

        return fetch(url, {
            method: 'POST',
            body: form_data
        });
    };

    const swapLang = local_lang => {
        const lang = local_lang.getLang();
        for (let i in lang)
            document.querySelector('#' + i).textContent = lang[i];
    };

    const inverseLang = async local_lang => {
        const list = App.getLangList();
        /* так как языка всего 2,
           можно инвертировать индекс */
        const lang = list[+!list.indexOf(
            local_lang.getCurrentLang()
        )];

        await local_lang.setLang(lang);
        swapLang(local_lang);

        return lang;
    };

    const validMail = mail => {
        /*check email*/
        const reg = /^[^!@#$%^&*()\-_=+,{}[\]?\s]*[a-z0-9]+@[a-z0-9]+\.[a-z0-9]+$/g;
        return reg.test(mail);
    };

    const getLangList = () => ["en", "ru"];

    return {
        init: async (local_lang, lang_btn_id) => {
            await local_lang.init();
            App.swapLang(local_lang);
            document.querySelector("#lang-btn").textContent
                = local_lang.getCurrentLang();

            document.querySelector(lang_btn_id)
                .addEventListener("click", e =>
                    App.inverseLang(local_lang).then(new_lang_name =>
                        e.target.textContent = new_lang_name
                    )
                );
        },
        loadJSON: loadJSON,
        uploadJSON: uploadJSON,
        swapLang: swapLang,
        inverseLang: inverseLang,
        validMail: validMail,
        getLangList: getLangList
    };
})();