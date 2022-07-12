const __ = (key, replace, grammaticalType = 0) => {
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

    let translationsArr = translation.split('|');

    if (translationsArr.length <= 1) {
        return translation;
    }

    var translationsGrammaticalTypes = [];
    translationsArr.forEach((element, index) => {
        translationsGrammaticalTypes[element.match(/[^{}]*(?=\})/g)[0]] = element.replace(/\{([0-9]+)\}/g, '');
    });

    return translationsGrammaticalTypes[grammaticalType];
}