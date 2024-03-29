<?php

namespace App\Repository;

use App\Entity\Question;
use App\Entity\Quiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 *
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function add(Question $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Question $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findRandom(Quiz $quiz, int $difficulty = 1): ?Question
    {
        $qb =  $this->createQueryBuilder('q')
            ->select('q.id')
            ->andWhere('q.difficulty = :difficulty')
            ->setParameter('difficulty', $difficulty)
        ;
        if ($quiz->getTopics()->count())
            $qb->andWhere('q.Topic in (:eventtopics)')
            ->setParameter('eventtopics', $quiz->getTopics());
        if ($quiz->getQuestions()->count())
            $qb->andWhere('q not in (:donequestions)')
            ->setParameter('donequestions', $quiz->getQuestions());
        $questions = $qb->getQuery()->getArrayResult();
        $qid = $questions ? $questions[rand(0, count($questions)-1)] : 0;
        return $this->createQueryBuilder('q')
            ->setMaxResults(1)
            ->where('q.id = :qid')
            ->setParameter('qid', $qid)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

//    /**
//     * @return Question[] Returns an array of Question objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Question
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
