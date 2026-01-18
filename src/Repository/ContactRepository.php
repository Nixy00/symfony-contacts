<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * @return Contact[]
     */
    public function search(?string $texte): array
    {
        $qb = $this->createQueryBuilder('c');

        if ($texte) {
            $qb->where('c.firstname LIKE :term OR c.lastname LIKE :term')
                ->setParameter('term', '%'.$texte.'%');
        }

        $qb->orderBy('c.lastname', 'ASC')
            ->addOrderBy('c.firstname', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
