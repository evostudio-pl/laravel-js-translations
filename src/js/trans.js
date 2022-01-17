const __ = (key, replace) => {
    let translation, translationNotFound = true;

    try {
        translation = key.split('.').reduce((t, i) => t[i] || null, JsTranslations.translations[JsTranslations.locale].php)

        if (translation) {
            translationNotFound = false
        }
    } catch (e) {
        translation = key
    }

    if (translationNotFound) {
        let translationsList = (JsTranslations.locale + '.json').split('.').reduce((p, c) => p && p[c] || null, JsTranslations.translations);

        translation = typeof(translationsList) !== 'undefined' && typeof(translationsList[key]) !== 'undefined'
            ? translationsList[key]
            : key;
    }

    _.forEach(replace, (value, key) => {
        translation = translation.replace(':' + key, value);
    })

    return translation;
}