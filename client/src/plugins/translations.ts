import { get } from 'lodash'
import { App } from 'vue'

declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    __: (translation: string, domain?: string) => string;
  }
}

const translate = get(window, ['wp', 'i18n', '__'], (translation: string) => translation)

export default {
  install(app: App, options: { domain: string }) {
    app.config.globalProperties['__'] = (translation: string, domain?: string) => translate(translation, domain || options.domain)
  },
}
