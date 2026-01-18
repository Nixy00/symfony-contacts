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
    public function search(string $texte): array
    {
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.lastname', 'ASC')
            ->addOrderBy('c.firstname', 'ASC');

        if ('' !== $texte) {
            $qb->where('c.lastname LIKE :texte OR c.firstname LIKE :texte')
                ->setParameter('texte', '%'.$texte.'%');
        }

        return $qb->getQuery()->getResult();
    }
}
