<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionQuiz
 *
 * @ORM\Table(name="question_quiz")
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
     * @var int|null
     *
     * @ORM\Column(name="idQuiz", type="integer", nullable=true)
     */
    private $idquiz;

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

    public function getIdquiz(): ?int
    {
        return $this->idquiz;
    }

    public function setIdquiz(?int $idquiz): self
    {
        $this->idquiz = $idquiz;

        return $this;
    }


}
