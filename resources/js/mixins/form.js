export default {
    methods: {
        setInputError(inputName, message) {
            let feedbackElement =  this.$el
                .querySelector('[name="' + inputName + '"]')
                .parentNode
                .querySelector('.invalid-feedback');

            if (!feedbackElement) {
                console.error('Could not find invalid-feedback element next to ' + inputName);
                return;
            }

            feedbackElement.classList.remove('hidden');
            feedbackElement.innerText = message;
        },
        handleFormErrors(response) {
            if (response.status === 422 && response.data && response.data.errors) {
                for (let [inputName, errors] of Object.entries(response.data.errors)) {
                    this.setInputError(inputName, errors[0]);
                }
            } else {
                console.error(response);
            }
        }
    }
}
