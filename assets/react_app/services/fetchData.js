const fetchData = async (url, callback) => {
    const response = await fetch(url);

    if (!response.ok) {
        return null;
        //throw new Error(`HTTP error! status: ${response.status}`);
    }

    const text = await response.text();
    if (text) {
        const data = JSON.parse(text);
        callback(data);
    }
}


export default fetchData

