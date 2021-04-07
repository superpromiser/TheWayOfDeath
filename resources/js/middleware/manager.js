import store from '~/store'

export default (to, from, next) => {
  if (store.getters['auth/user'].role.roleName !== 'manager') {
    next({ name: 'home' })
  } else {
    next()
  }
}
