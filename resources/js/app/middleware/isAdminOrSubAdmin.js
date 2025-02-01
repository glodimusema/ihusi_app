export default (to, from, next) => {
    const auth =  window.emerfine.user.id_role
    auth !== 3 ? next({ name: 'infos' }) : '';
}