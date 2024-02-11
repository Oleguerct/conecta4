const mercureUrlTemplate = JSON.parse(document.getElementById("mercure-url").textContent);

function getMercureIRIUrl(iri){
    return mercureUrlTemplate.replace('TOPICIRI', iri)
}

export default getMercureIRIUrl
