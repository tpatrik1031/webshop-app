import {trans} from "laravel-vue-i18n";

const translationsObject = {
    translations: {
        next: trans('next'),
        no_results_found: trans('noResultsFound'),
        of: trans('of'),
        per_page: trans('perPage'),
        previous: trans('previous'),
        results: trans('results'),
        to: trans('to'),
        reset: trans('reset'),
    }
};

export default translationsObject.translations;

export function getTranslations() {
    return translationsObject.translations;
}

export function setTranslation(key, value) {
    translationsObject.translations[key] = value;
}

export function setTranslations(translations) {
    translationsObject.translations = translations;
}
