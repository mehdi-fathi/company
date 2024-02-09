<?php


namespace App\Validator;

use App\Repository\CompanyRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 *
 */
class UniqueCompanyNameValidator extends ConstraintValidator
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

        $referencedEntity = $this->companyRepository->findOneBy(['name' => $value]);

        if ($referencedEntity) {

            // the argument must be a string or an object implementing __toString()
            $this->context->buildViolation($constraint->message)
                ->setParameter("{{ value }}", $value)
                ->addViolation();
        }
    }
}
