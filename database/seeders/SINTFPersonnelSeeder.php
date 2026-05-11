<?php

namespace Database\Seeders;

use App\Models\Entreprise;
use App\Models\Personnel;
use Illuminate\Database\Seeder;

class SINTFPersonnelSeeder extends Seeder
{
    public function run(): void
    {
        $entreprise = Entreprise::where('nom', 'like', '%SINTF%')->first();

        if (! $entreprise) {
            $this->command->error('Entreprise SINTF introuvable. Vérifiez le nom exact dans la table entreprises.');
            return;
        }

        $this->command->info("Entreprise : {$entreprise->nom} (id: {$entreprise->id})");

        $imported = 0;
        $skipped  = 0;

        foreach ($this->getData() as $row) {
            [$nom, $prenoms] = $this->splitName($row['nomPrenom']);

            $exists = Personnel::where('entreprise_id', $entreprise->id)
                ->where('matricule', $row['matricule'])
                ->exists();

            if ($exists) {
                $skipped++;
                $this->command->line("  - Ignoré (doublon) : {$row['matricule']} — {$row['nomPrenom']}");
                continue;
            }

            Personnel::create([
                'entreprise_id'         => $entreprise->id,
                'matricule'             => $row['matricule'],
                'nom'                   => $nom,
                'prenoms'               => $prenoms,
                'civilite'              => $row['civilite'],
                'sexe'                  => $row['sexe'],
                'date_naissance'        => $row['date_naissance'],
                'adresse'               => $row['adresse'],
                'telephone'             => $row['telephone'],
                'numero_identification' => $row['identification'],
                'poste'                 => $row['poste'],
                'type_contrat'          => $row['contrat'],
                'date_embauche'         => $row['date_entree'],
                'date_fin_contrat'      => $row['date_sortie'],
                'police'                => $row['police'],
                'is_active'             => true,
            ]);

            $imported++;
            $this->command->line("  + Importé : {$row['matricule']} — {$nom} {$prenoms}");
        }

        $this->command->info("Terminé — Importés : {$imported} | Doublons ignorés : {$skipped}");
    }

    /**
     * Sépare "NOM PRENOM" en [nom, prenoms].
     * Les mots entièrement en majuscules (longueur > 1, sans point) forment le nom.
     */
    private function splitName(string $nomPrenom): array
    {
        $parts       = preg_split('/\s+/', trim($nomPrenom));
        $nomParts    = [];
        $prenomParts = [];
        $inPrenom    = false;

        foreach ($parts as $part) {
            if (
                ! $inPrenom
                && strlen($part) > 1
                && strpos($part, '.') === false
                && $part === mb_strtoupper($part, 'UTF-8')
            ) {
                $nomParts[] = $part;
            } else {
                $inPrenom      = true;
                $prenomParts[] = $part;
            }
        }

        return [
            implode(' ', $nomParts) ?: $nomPrenom,
            implode(' ', $prenomParts) ?: null,
        ];
    }

    private function getData(): array
    {
        return [
            ['matricule' => 'TEMP7250', 'nomPrenom' => 'BADINI E. Génévieve',                        'civilite' => 'Mme', 'sexe' => 'Féminin',  'date_naissance' => '2003-11-17', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '65734737',    'identification' => '09010200110035542',  'poste' => 'Assistante comptable',                          'contrat' => 'CDD', 'date_entree' => '2025-01-23', 'date_sortie' => '2027-01-22', 'police' => '457W931'],
            ['matricule' => 'TEMP6871', 'nomPrenom' => 'BADO Baya Fidele',                            'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1983-01-01', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '75 07 32 60', 'identification' => '09010200121036735',  'poste' => 'Chef de section et controleur interne',         'contrat' => 'CDD', 'date_entree' => '2025-03-10', 'date_sortie' => '2027-03-09', 'police' => '258A411'],
            ['matricule' => 'TEMP9506', 'nomPrenom' => 'BONI Namoussi Barnabe',                       'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1997-06-11', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '75 78 96 55', 'identification' => '09030500600002689',  'poste' => 'Superviseur',                                   'contrat' => 'CDD', 'date_entree' => '2025-08-01', 'date_sortie' => '2026-07-31', 'police' => '943M582'],
            ['matricule' => 'TEMP9173', 'nomPrenom' => 'BOUDA Moussa',                                'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '2004-12-31', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '56 65 42 26', 'identification' => '09010200124053383',  'poste' => 'Superviseur',                                   'contrat' => 'CDD', 'date_entree' => '2024-11-01', 'date_sortie' => '2026-10-31', 'police' => '074O659'],
            ['matricule' => 'TEMP7734', 'nomPrenom' => 'DIALLO Moussa',                               'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1988-01-01', 'adresse' => 'Bobo Dioulasso',    'telephone' => '04 66 01 94', 'identification' => '09020201100000766',  'poste' => 'Superviseur',                                   'contrat' => 'CDI', 'date_entree' => '2026-01-07', 'date_sortie' => null,         'police' => '466P521'],
            ['matricule' => 'TEMP8214', 'nomPrenom' => 'DOULKOUM KOANDA Balawendé Pauline Safiétou', 'civilite' => 'Mme', 'sexe' => 'Féminin',  'date_naissance' => '1991-01-06', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '70 58 98 62', 'identification' => '09010200111002892',  'poste' => 'Assistante au responsable qualité',             'contrat' => 'CDD', 'date_entree' => '2025-11-14', 'date_sortie' => '2026-11-13', 'police' => '855S989'],
            ['matricule' => 'TEMP4441', 'nomPrenom' => 'GAMBO T. Wilfried',                           'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1987-08-28', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '70 80 93 45', 'identification' => '03010400230007194',  'poste' => 'Comptable',                                     'contrat' => 'CDI', 'date_entree' => '2024-03-01', 'date_sortie' => null,         'police' => '570W646'],
            ['matricule' => 'TEMP9375', 'nomPrenom' => 'HEMA B Elisée',                               'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '2001-08-09', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '64 71 27 42', 'identification' => null,                  'poste' => 'Maintenancier',                                 'contrat' => 'CDD', 'date_entree' => '2025-05-03', 'date_sortie' => '2026-05-02', 'police' => '812C044'],
            ['matricule' => 'TEMP6527', 'nomPrenom' => 'IDANI Y. Seydou',                             'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1994-07-20', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '54 05 54 21', 'identification' => '08020300102002839',  'poste' => 'Responsable certification et controle interne', 'contrat' => 'CDD', 'date_entree' => '2025-11-01', 'date_sortie' => '2026-10-31', 'police' => '933N871'],
            ['matricule' => 'TEMP2102', 'nomPrenom' => 'IDO Michel',                                  'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '2001-09-29', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '74 91 51 92', 'identification' => '090102001244044277', 'poste' => 'Superviseur',                                   'contrat' => 'CDD', 'date_entree' => '2024-11-01', 'date_sortie' => '2026-10-31', 'police' => '619E919'],
            ['matricule' => 'TEMP2386', 'nomPrenom' => 'IDO Moussa',                                  'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1991-01-01', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '07 64 33 27', 'identification' => '06030600800000370',  'poste' => 'Superviseur',                                   'contrat' => 'CDI', 'date_entree' => '2024-11-01', 'date_sortie' => null,         'police' => '133X133'],
            ['matricule' => 'TEMP8931', 'nomPrenom' => 'IDO Sylvain',                                 'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '2002-12-31', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '77 34 78 32', 'identification' => '06030600800000346',  'poste' => 'Superviseur',                                   'contrat' => 'CDD', 'date_entree' => '2024-11-01', 'date_sortie' => '2026-10-31', 'police' => '946I824'],
            ['matricule' => 'TEMP2611', 'nomPrenom' => 'KOAMA Eric',                                  'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1984-07-09', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '76 59 90 04', 'identification' => '09010200125002205',  'poste' => 'Chef de production',                            'contrat' => 'CDI', 'date_entree' => '2024-01-01', 'date_sortie' => null,         'police' => '122D328'],
            ['matricule' => 'TEMP2375', 'nomPrenom' => 'KOUAMA Honorine',                             'civilite' => 'Mme', 'sexe' => 'Féminin',  'date_naissance' => '1998-02-10', 'adresse' => 'Bobo Dioulasso',    'telephone' => '55 59 87 62', 'identification' => '09010200125026304',  'poste' => 'Assistante de direction',                       'contrat' => 'CDD', 'date_entree' => '2026-01-20', 'date_sortie' => '2027-01-19', 'police' => '751D478'],
            ['matricule' => 'TEMP7071', 'nomPrenom' => 'KABORE Blaise Pascal',                        'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1997-07-28', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '74 53 40 41', 'identification' => '090010200125016088', 'poste' => 'GRH',                                           'contrat' => 'CDD', 'date_entree' => '2026-02-10', 'date_sortie' => '2027-02-09', 'police' => '949I725'],
            ['matricule' => 'TEMP7950', 'nomPrenom' => 'NEBIE Joachim',                               'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1995-07-27', 'adresse' => 'Bobo Dioulasso',    'telephone' => '67109654',    'identification' => '09010200115049719',  'poste' => 'Superviseur',                                   'contrat' => 'CDD', 'date_entree' => '2024-11-01', 'date_sortie' => '2026-10-31', 'police' => '226D057'],
            ['matricule' => 'TEMP9254', 'nomPrenom' => 'OUATTARA Sali',                               'civilite' => 'Mme', 'sexe' => 'Féminin',  'date_naissance' => '1996-04-20', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '75821813',    'identification' => '09010200109012743',  'poste' => 'Controleur Qualite',                            'contrat' => 'CDD', 'date_entree' => '2024-03-01', 'date_sortie' => '2027-02-28', 'police' => '844B716'],
            ['matricule' => 'TEMP2255', 'nomPrenom' => 'OUOBA David',                                 'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1994-01-01', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '07749537',    'identification' => null,                  'poste' => 'Maintenancier',                                 'contrat' => 'CDD', 'date_entree' => '2025-11-14', 'date_sortie' => '2026-05-13', 'police' => '682G124'],
            ['matricule' => 'TEMP9479', 'nomPrenom' => 'SANOGO Bintou',                               'civilite' => 'Mme', 'sexe' => 'Féminin',  'date_naissance' => '1984-03-23', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '07601539',    'identification' => '09010200106016632',  'poste' => 'Superviseur',                                   'contrat' => 'CDD', 'date_entree' => '2025-08-01', 'date_sortie' => '2026-07-31', 'police' => '919F371'],
            ['matricule' => 'TEMP4703', 'nomPrenom' => 'SANOGO Mariame',                              'civilite' => 'Mme', 'sexe' => 'Féminin',  'date_naissance' => '1980-03-31', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '65 98 99 33', 'identification' => '09011300200002773',  'poste' => 'Superviseur',                                   'contrat' => 'CDI', 'date_entree' => '2019-04-01', 'date_sortie' => null,         'police' => '432A765'],
            ['matricule' => 'TEMP2219', 'nomPrenom' => 'SANOU Abdoul Aziz',                           'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1990-02-23', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '64 14 49 69', 'identification' => '09010200121003785',  'poste' => 'Chauffeur',                                     'contrat' => 'CDD', 'date_entree' => '2026-01-01', 'date_sortie' => '2026-12-31', 'police' => '180U390'],
            ['matricule' => 'TEMP8163', 'nomPrenom' => 'SIDIBE Siaka',                                'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1996-06-25', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '57318639',    'identification' => '09011101700003482',  'poste' => 'Superviseur',                                   'contrat' => 'CDD', 'date_entree' => '2025-01-01', 'date_sortie' => '2026-12-31', 'police' => '791R924'],
            ['matricule' => 'TEMP3956', 'nomPrenom' => 'TRAORE Doulaye',                              'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1974-10-14', 'adresse' => 'Bobo Dioulasso',    'telephone' => '65 82 32 96', 'identification' => null,                  'poste' => 'Chauffeur',                                     'contrat' => 'CDD', 'date_entree' => '2024-05-15', 'date_sortie' => '2026-05-14', 'police' => '642L266'],
            ['matricule' => 'TEMP9387', 'nomPrenom' => 'TRAORE Karidjata',                            'civilite' => 'Mme', 'sexe' => 'Féminin',  'date_naissance' => '1986-01-01', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '74 54 88 53', 'identification' => '09011101900000005',  'poste' => 'Superviseur',                                   'contrat' => 'CDD', 'date_entree' => '2025-08-01', 'date_sortie' => '2026-07-31', 'police' => '595U236'],
            ['matricule' => 'TEMP9643', 'nomPrenom' => 'TRAORE Ye',                                   'civilite' => 'Mme', 'sexe' => 'Féminin',  'date_naissance' => '1994-06-24', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '66 32 29 92', 'identification' => '09021000101002626',  'poste' => 'Superviseur',                                   'contrat' => 'CDD', 'date_entree' => '2025-08-01', 'date_sortie' => '2026-07-31', 'police' => '768D358'],
            ['matricule' => 'TEMP4826', 'nomPrenom' => 'WARE Gabirou Mohamed',                        'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1991-12-31', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '72 49 62 86', 'identification' => '10030700113001428',  'poste' => 'Responsable Qualite',                           'contrat' => 'CDI', 'date_entree' => '2019-04-01', 'date_sortie' => null,         'police' => '018H402'],
            ['matricule' => 'TEMP7762', 'nomPrenom' => 'ZOROUM Fati',                                 'civilite' => 'Mme', 'sexe' => 'Féminin',  'date_naissance' => '1981-03-06', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '61 60 51 41', 'identification' => '09010200121029270',  'poste' => 'Controleur Qualite',                            'contrat' => 'CDI', 'date_entree' => '2019-04-01', 'date_sortie' => null,         'police' => '139M023'],
            ['matricule' => 'TEMP1463', 'nomPrenom' => 'IDO Nebnoma',                                 'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1977-01-01', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '76 66 50 84', 'identification' => '00103019000002323',  'poste' => 'Gerant',                                        'contrat' => 'CDI', 'date_entree' => '2014-01-01', 'date_sortie' => null,         'police' => null],
            ['matricule' => 'TEMP1679', 'nomPrenom' => 'TOE Dikio Claudel Rufin',                     'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1986-06-22', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '76 69 82 23', 'identification' => '09010200105000315',  'poste' => 'Gerant Adjoint',                                'contrat' => 'CDI', 'date_entree' => '2024-01-01', 'date_sortie' => null,         'police' => null],
            ['matricule' => 'SI002A',   'nomPrenom' => 'TRAORE Lona Issa',                            'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1998-10-03', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '76 36 64 18', 'identification' => '09010200110029662',  'poste' => 'Maintenancier',                                 'contrat' => 'CDD', 'date_entree' => '2026-04-15', 'date_sortie' => '2027-04-14', 'police' => '576D595'],
            ['matricule' => 'SI003A',   'nomPrenom' => 'TRAORE Aboubacar Sidiki',                     'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1996-07-04', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '77 44 49 14', 'identification' => '09010200110024743',  'poste' => 'Maintenancier',                                 'contrat' => 'CDD', 'date_entree' => '2026-04-27', 'date_sortie' => '2027-04-26', 'police' => '072R054'],
            ['matricule' => 'SI004A',   'nomPrenom' => 'KIENTEGA Kiswendsida Jean-Luc',               'civilite' => 'M.', 'sexe' => 'Masculin', 'date_naissance' => '1998-08-21', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '75 43 30 31', 'identification' => '10020900101002768',  'poste' => 'Superviseur Adjoint',                           'contrat' => 'CDD', 'date_entree' => '2026-04-09', 'date_sortie' => '2027-04-08', 'police' => '247F267'],
            ['matricule' => 'SI005A',   'nomPrenom' => 'SAWADOGO Fadilatou',                          'civilite' => 'Mme', 'sexe' => 'Féminin',  'date_naissance' => '1996-05-25', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '65 14 19 52', 'identification' => '09010200122023485',  'poste' => 'Superviseur Adjointe',                          'contrat' => 'CDD', 'date_entree' => '2026-04-09', 'date_sortie' => '2027-04-08', 'police' => '739U278'],
            ['matricule' => 'SI006A',   'nomPrenom' => 'CONDA Bozo Orokia',                           'civilite' => 'Mme', 'sexe' => 'Féminin',  'date_naissance' => '2000-03-21', 'adresse' => 'Bobo-Dioulasso',    'telephone' => '55 40 35 17', 'identification' => '09010200111069653',  'poste' => 'Productrice de jus',                            'contrat' => 'CDD', 'date_entree' => '2026-03-01', 'date_sortie' => '2026-08-31', 'police' => '660J602'],
        ];
    }
}
