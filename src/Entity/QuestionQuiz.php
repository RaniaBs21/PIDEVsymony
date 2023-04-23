<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionQuiz
 *
 * @ORM\Table(name="question_quiz", indexes={@ORM\Index(name="id_quiz_2", columns={"id_quiz"}), @ORM\Index(name="id_quiz", columns={"id_quiz"})})
 * @ORM\Entity
 */
class QuestionQuiz
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_quest", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idQuest;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_question", type="string", length=200, nullable=false)
     */
    private $descQuestion;

    /**
     * @var \Quiz
     *
     * @ORM\ManyToOne(targetEntity="Quiz")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_quiz", referencedColumnName="id_quiz")
     * })
     */
    private $idQuiz;

    public function getIdQuest(): ?int
    {
        return $this->idQuest;
    }

    public function getDescQuestion(): ?string
    {
        return $this->descQuestion;
    }

    public function setDescQuestion(string $descQuestion): self
    {
        $this->descQuestion = $descQuestion;

        return $this;
    }

    public function getIdQuiz(): ?Quiz
    {
        return $this->idQuiz;
    }

    public function setIdQuiz(?Quiz $idQuiz): self
    {
        $this->idQuiz = $idQuiz;

        return $this;
    }


}
