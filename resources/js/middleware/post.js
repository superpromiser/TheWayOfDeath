import store from '~/store'

export default (to, from, next) => {
  if (store.getters['auth/user'].roleId == '4' || store.getters['auth/user'].roleId == '5') {
    next({ name: 'home' })
  } else {
    next()
  }
}
