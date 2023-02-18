<?php

namespace App\Repository;

use App\Entity\Purchase;
use App\Entity\Trip;
use App\Model\TripFilters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trip>
 *
 * @method Trip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trip[]    findAll()
 * @method Trip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TripRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trip::class);
    }

    public function getFilteredTrips(TripFilters $filters, int $offset, int $limit): Paginator
    {
        $query = $this->createQueryBuilder('t')
            ->addSelect([
                't.id',
                't.price',
                't.description',
                't.name',
                't.date_start',
                't.date_end',
                't.duration',
                't.country',
                't.img',
                't.free_places',
            ]);

        if (null !== $filters->getCountries()) {
            foreach ($filters->getCountries() as $key => $country) {
                if (0 === $key) {
                    $query->andWhere('t.country = :country'.$key)->setParameter('country'.$key, $country);
                } else {
                    $query->orWhere('t.country = :country'.$key)->setParameter('country'.$key, $country);
                }
            }
        }

        if (null !== $filters->getDateStart()) {
            $query->andWhere('t.date_start >= :date_start')->setParameter('date_start', $filters->getDateStart());
        }

        if (null !== $filters->getDateEnd()) {
            $query->andWhere('t.date_end >= :date_end')->setParameter('date_end', $filters->getDateEnd());
        }

        if (null !== $filters->getMinSum()) {
            $query->andWhere('t.price > :price')->setParameter('price', $filters->getMinSum());
        }

        if (null !== $filters->getMaxSum()) {
            $query->andWhere('t.price < :price')->setParameter('price', $filters->getMaxSum());
        }

        if (null !== $filters->getSearchQuery()) {
            $query->andWhere('t.name LIKE :search')
                ->setParameter('search', '%'.$filters->getSearchQuery().'%');
        }

        $query->addOrderBy(null === $filters->getSortBy() ? 't.id' : 't.'.$filters->getSortBy(),
            null === $filters->getSortOrder() ? 'ASC' : $filters->getSortOrder())
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return new Paginator($query, false);
    }

    public function updateFreePlaces(Trip $trip, Purchase $purchase)
    {
        $updatedTrip = $trip;
        $updatedTrip->setFreePlaces($trip->getFreePlaces() - $purchase->getPeople());
        $this->getEntityManager()->flush();
    }

    public function getTripForPurchase(int $id): array
    {
        $qb = $this->createQueryBuilder('t')
            ->addSelect(
                ['t.price',
                    't.free_places'])
            ->where('t.id = :id')
            ->setParameter('id', $id);

        $query = $qb->getQuery();

        return $query->getResult();
    }

    public function add(Trip $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Trip $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
