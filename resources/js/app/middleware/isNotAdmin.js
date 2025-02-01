export default (to, from, next) => {
    const auth =  window.emerfine.user.id_role
    auth !== 1 ? next({ name: 'infos' }) : '';
}