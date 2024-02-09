<?php


namespace App\Validator\Company;

use App\Repository\CompanyRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 *
 */
class ExistCompanyForeignKeyValidator extends ConstraintValidator
{

    /**
     * @param \App\Repository\CompanyRepository $companyRepository
     */
    public function __construct(private CompanyRepository $companyRepository)
    {
    }

    /**
     * @param $value
     * @param \Symfony\Component\Validator\Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint)
    {

        if (!$constraint->foreignKey) {
            throw new \InvalidArgumentException('You must specify "foreignKey" properties.');
        }

        $referencedEntity = $this->companyRepository->findOneBy([$constraint->foreignKey => $value]);

        if (!$referencedEntity) {

            // the argument must be a string or an object implementing __toString()
            $this->context->buildViolation($constraint->message)
                ->setParameter("{{ value }}", $value)
                ->setParameter("{{ entityName }}", $constraint->entityName)
                ->addViolation();
        }
    }
}
