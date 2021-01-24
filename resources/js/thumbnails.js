/**
 * Returns a promise for when a DOM element becomes available.
 *
 * @param selector
 * @returns {Promise<*>}
 */
const onReady = async (selector) => {
    while (document.querySelector(selector) === null) {
        await new Promise(resolve => requestAnimationFrame(resolve))
    }

    return document.querySelector(selector)
}

/**
 * Converts a rgba() string to a hex value.
 *
 * @param orig
 * @returns {string|*}
 */
const hex = (orig) => {
    var rgb = orig.replace(/\s/g,'').match(/^rgba?\((\d+),(\d+),(\d+)/i);
    return (rgb && rgb.length === 4) ?
        ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : orig;
}

/**
 * Refreshes the cards image with the updated options.
 *
 * @param opts
 */
const updateCards = (opts) => {
    const { text_color, background_color } = opts;

    if (text_color && text_color !== '' && background_color && background_color !== '') {
        const imageContainers = document.querySelectorAll('.thumbnails-social-cards--card-image');

        imageContainers.forEach(imageContainer => {
            const imageURL = imageContainer.getAttribute('data-url');

            imageContainer.innerHTML = '';
            imageContainer.innerHTML = `<img src="${imageURL}/${hex(text_color)}/${hex(background_color)}">`;
        })
    }
}

Statamic.booting(() => {
    onReady('.publish-section').then((targetNode) => {
        const config = { attributes: true, childList: true, subtree: true };
        const callback = (mutationsList, _) => {
            for(const mutation of mutationsList) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                    updateCards({
                        text_color: document.querySelector('.publish-field__text_color .pickr button').style.color,
                        background_color: document.querySelector('.publish-field__background_color .pickr button').style.color
                    })
                }
            }
        }

        const observer = new MutationObserver(callback);
        observer.observe(targetNode, config);
    })
});
