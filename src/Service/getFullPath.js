function getFullPath(path){
    let baseUrl = JSON.parse(document.getElementById('base-url').textContent);
    return baseUrl + path;
}
export default getFullPath;