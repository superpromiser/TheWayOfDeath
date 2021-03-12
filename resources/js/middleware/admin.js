import store from '~/store'

export default (to, from, next) => {
  if (store.getters['auth/user'].role.roleName !== 'admin') {
    next({ name: 'home' })
  } else {
    next()
  }
}
