export default function __(key, replace) {
    let translation, translationNotFound = true;

    try {
        translation = key.split('.').reduce((t, i) => t[i] || null, Evo.translations[Evo.locale].php)

        if (translation) {
            translationNotFound = false
        }
    } catch (e) {
        translation = key
    }

    if (translationNotFound) {
        let translationsList = (Evo.locale + '.json').split('.').reduce((p, c) => p && p[c] || null, Evo.translations);

        translation = typeof(translationsList) !== 'undefined' && typeof(translationsList[key]) !== 'undefined'
            ? translationsList[key]
            : key;
    }

    _.forEach(replace, (value, key) => {
        translation = translation.replace(':' + key, value);
    })

    return translation;
}