import Axios from "axios";

const nextButton = document.querySelector('#next_button');
const questions = document.querySelectorAll('.question');
let activeQuestion;
let progress = 0;

window.onload = (e) => {
    if (questions.length > 0) {
        questions[0].classList.add('question--active');
        activeQuestion = questions[0];
        updateProgressBar(progress);
        handleNextButton();
    }
}

const answerButtons = document.querySelectorAll('.question__answer');

if (answerButtons) {
    answerButtons.forEach(button => {
        button.addEventListener('click', event => {
            const choiceId = button.getAttribute('data-id');
            saveAnswer(choiceId);
            nextButton.removeAttribute('disabled');
            answerButtons.forEach(button => {
                button.classList.remove('question__answer--selected');
            });
            button.classList.add('question__answer--selected');
        });
    });
}
if (nextButton) {
    nextButton.addEventListener('click', nextButtonAction);
}

async function saveAnswer(choiceId) {
    //make ajax call to "answer/save"
    const response = await Axios({
        url: `/answer/save`,
        method: 'POST',
        data: {
            choice_id: choiceId,
        },
    });
}

function getNextQuestion() {
    let nextQuestion;

    Array.from(questions).forEach((question, index) => {
        if (question == activeQuestion) {
            nextQuestion = questions[index+1];
            return;
        }
    })

    return nextQuestion;
}

function nextButtonAction(event) {
    const nextQuestion = getNextQuestion();

    progress++;
    updateProgressBar(progress);

    activeQuestion.classList.remove('question--active');
    nextButton.setAttribute('disabled', true);

    if (nextQuestion) {
        nextQuestion.classList.add('question--active');
        activeQuestion = nextQuestion;
    }

    handleNextButton();
}

function handleNextButton() {
    if (!getNextQuestion()) {
        nextButton.innerHTML = '✓';
        nextButton.removeEventListener('click', nextButtonAction);
        nextButton.addEventListener('click', event => {
            window.location.href = '/result/store';
        });
    }
}

function updateProgressBar(questionsAnswered) {
    document.querySelector('#progress_bar').style.setProperty('--questions-answered', questionsAnswered);
}