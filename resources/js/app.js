import.meta.glob(["../images/**"]);
import "bootstrap";

document.addEventListener('DOMContentLoaded', () => {
    // Select all the radio buttons for answers
    const answerRadios = document.querySelectorAll('.answer-radio');

    answerRadios.forEach(radio => {
        let wasChecked = false;

        // On mousedown, we record if the radio was already checked.
        // This fires before the 'click' event.
        const mouseDownHandler = () => {
            wasChecked = radio.checked;
        };
        
        // On click, we decide what to do.
        const clickHandler = (event) => {
            // If it was checked before the click, it means the user is trying to un-check it.
            if (wasChecked) {
                // We use preventDefault and manually set checked to false.
                event.preventDefault();
                radio.checked = false;
            }
        };

        // We need to listen on the label as well, because a click on the label
        // triggers a click on the radio.
        const label = radio.nextElementSibling;
        if (label && label.classList.contains('answer-label')) {
            label.addEventListener('mousedown', mouseDownHandler);
            label.addEventListener('click', clickHandler);
        }
        
        // Also listen on the radio itself in case it becomes visible or for other reasons.
        radio.addEventListener('mousedown', mouseDownHandler);
        radio.addEventListener('click', clickHandler);
    });
});
