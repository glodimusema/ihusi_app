export default (to, from, next) => {
    const auth =  window.emerfine.user.id_role
    auth !== 2 ? next({ name: 'infos' }) : '';
}