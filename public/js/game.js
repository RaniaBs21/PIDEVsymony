const question = document.querySelector('#question');
const choices = Array.from(document.querySelectorAll('.choice-text'));
const ProgressText = document.querySelector('#progressText');
const scoreText = document.querySelector('#score');
const progressBarFull = document.querySelector('#progressBarFull');

let currentQuestion = {}
let acceptingAnswers = true
let score = parseInt(scoreText.innerText)
let questionCounter = 0
let availableQuestions = []
console.log(`Score: ${score}`);

let questions = [
    {
        question: 'Quel est le nom de l’architecte du musée d’art contemporain de Niteroi - Brésil ?',
        choice1: ' Fernando Romero',
        choice2: ' Oscar Niemeyer',
        choice3: 'Franck Gehry',
        choice4: ' Jean Nouvel',
        answer: 3,
    },
    {
        question: 'Qu’est-ce qu’une “performance” ?',
        choice1: ' Une prouesse artistique',
        choice2: ' Une technique de peinture',
        choice3: 'Une manifestation artistique',
        choice4: ' Une œuvre où l’action du corps est au cœur du concept',
        answer: 1,
    },
    {
        question: 'Souvent des artistes sont invités par des grandes marques à collaborer avec des grandes marques',
        choice1: 'Christian Dior',
        choice2: 'Louis Vuitton',
        choice3: ' Comme des garçons',
        choice4: ' Adidas',
        answer: 4,
    },
    {
        question: 'Qui a écrit La Chartreuse de Parme ?',
        choice1: 'Balzac',
        choice2: 'Standhal',
        choice3: 'Flaubert',
        choice4: 'Marivaux',
        answer: 3,
    },
    {
        question: '“Impression, soleil levant” est un tableau de :',
        choice1: 'Turner',
        choice2: 'Monet',
        choice3: 'corot',
        choice4: 'Picasso',
        answer: 2,
    },

]

const SCORE_POINTS = 100
const MAX_QUESTIONS = 5

startGame = () => {
    questionCounter = 0;
    score = 0;
    availableQuestions = [...questions]
    getNewQuestion()
}

getNewQuestion = () =>{
    if(availableQuestions.length ===0 || questionCounter >= MAX_QUESTIONS){
        localStorage.setItem('mostRecentScore', score)
        return window.location.assign('/end')
    }
    questionCounter++
    ProgressText.innerText = `Question ${questionCounter} of ${MAX_QUESTIONS}`
    progressBarFull.style.width = `${(questionCounter/MAX_QUESTIONS) * 100}%`

    const questionsIndex = Math.floor(Math.random() * availableQuestions.length)
    currentQuestion = availableQuestions[questionsIndex]
    question.innerText = currentQuestion.question

    choices.forEach(choice =>{
        const number = choice.dataset['number']
        choice.innerText = currentQuestion['choice' + number]
    })
    availableQuestions.splice(questionsIndex, 1)
    acceptingAnswers = true

}

choices.forEach(choice =>{
    choice.addEventListener('click', e => {
        if(!acceptingAnswers) return

        acceptingAnswers = false
        const selectedChoice = e.target
        const selectedAnswer = selectedChoice.dataset['number']

        let classToApply = selectedAnswer === currentQuestion.answer ? 'correct' : 'incorrect'
        if(classToApply === 'correct'){
            incrementScore(SCORE_POINTS)
        }
        selectedChoice.parentElement.classList.add(classToApply)

        setTimeout(() => {
            selectedChoice.parentElement.classList.remove(classToApply)
            getNewQuestion()
        },1000)
    })
})

incrementScore = num => {
    score +=num
    scoreText.innerText = score
}
startGame()