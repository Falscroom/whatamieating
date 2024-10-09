import { createI18n } from 'vue-i18n'
import {ru} from '@shared/locate';

export const i18n = createI18n({
    locale: 'ru',
    fallbackLocale: 'ru',
    messages: {
        ru: ru,
    }
})
