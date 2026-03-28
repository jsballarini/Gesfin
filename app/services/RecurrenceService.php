<?php

class RecurrenceService {
    private $entryRepo;
    private $recurrenceRepo;

    public function __construct($entryRepo, $recurrenceRepo) {
        $this->entryRepo = $entryRepo;
        $this->recurrenceRepo = $recurrenceRepo;
    }

    public function generateRecurrence($baseData, $months) {
        // Cria o grupo de recorrência
        $groupId = $this->recurrenceRepo->createGroup($months);
        $baseData['recurrence_group_id'] = $groupId;

        $baseDate = new DateTime($baseData['due_date']);
        $originalDay = (int)$baseDate->format('d');

        for ($i = 0; $i < $months; $i++) {
            $currentData = $baseData;
            
            // Clona a data base para não alterar a original e adiciona os meses
            $date = clone $baseDate;
            $date->modify("+{$i} months");

            // Ajuste para meses curtos (ex: dia 31 de janeiro -> 28/29 de fevereiro)
            // Se o mês gerado for diferente do mês esperado matematicamente,
            // significa que o PHP jogou para o próximo mês. Voltamos para o último dia do mês correto.
            $expectedMonth = (int)$baseDate->format('m') + $i;
            $expectedYear = (int)$baseDate->format('Y') + floor(($expectedMonth - 1) / 12);
            $expectedMonth = (($expectedMonth - 1) % 12) + 1;

            if ((int)$date->format('m') !== $expectedMonth) {
                // Modifica para o último dia do mês esperado
                $date->setDate($expectedYear, $expectedMonth, 1);
                $date->modify('last day of this month');
            }

            $currentData['due_date'] = $date->format('Y-m-d');
            $currentData['competence_year'] = $date->format('Y');
            $currentData['competence_month'] = $date->format('n');

            $this->entryRepo->create($currentData);
        }

        return true;
    }

    public function deleteFutureEntries($groupId, $fromDate) {
        return $this->recurrenceRepo->deleteFutureEntries($groupId, $fromDate);
    }
}