<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Helper\FileManagerHelper;
use App\Models\Organization;
use App\Models\Priority;
use App\Models\Project;
use App\Models\Status;
use App\Models\Todo;
use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            ColorSeeder::class,
            PrioritySeeder::class,
            StatusSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Tom Cremer',
            'email' => 'tomcremer2903@gmail.com',
            'password' => bcrypt('azertyuiop$')
        ]);
        $users = collect([
            User::factory()->create([
                'name' => 'Marc Martin',
                'email' => 'beta+member1@horixt.com',
                'password' => bcrypt('password')
            ]),
            User::factory()->create([
                'name' => 'Valentine Delacroix',
                'email' => 'beta+member2@horixt.com',
                'password' => bcrypt('password')
            ]),
            User::factory()->create([
                'name' => 'Bob Evans',
                'email' => 'beta+member3@horixt.com',
                'password' => bcrypt('password')
            ]),
            User::factory()->create([
                'name' => 'Geoffrey Touette',
                'email' => 'beta+member4@horixt.com',
                'password' => bcrypt('password')
            ]),
            User::factory()->create([
                'name' => 'Lucas Gava',
                'email' => 'beta+member5@horixt.com',
                'password' => bcrypt('password')
            ]),
            User::factory()->create([
                'name' => 'Anthony De Sousa',
                'email' => 'beta+member6@horixt.com',
                'password' => bcrypt('password')
            ]),
        ]);

        $jean = User::factory()->create([
            'name' => 'Jean Adams',
            'email' => 'jean@horixt.com',
            'password' => bcrypt('password')
        ]);


        $beta = Organization::factory()->create([
            'name' => 'Nexus',
            'slug' => 'nexus',
            'owner_id' => $users[0]->id,
        ]);



        // Promote owner
        setPermissionsTeamId($beta->id);
        $users[0]->assignRole(RoleEnum::ADMIN->value);
        FileManagerHelper::createOrganizationDirectory($beta, $users[0]);


        // Attach users aux orgs + rôles
        foreach ($users as $user) {
            $user->organizations()->attach($beta->id);
            setPermissionsTeamId($beta->id);
            $user->assignRole(RoleEnum::MEMBER->value);

        }


        $betaProjects = [
            'Zila' => [
                'description' => 'Projet de développement d’une plateforme collaborative.',
                'tasks' => [
                    'Prise en main du brief client' => [
                        'Lire le cahier des charges',
                        'Lister les points à clarifier',
                        'Organiser une réunion d’équipe',
                    ],
                    'UI/UX – Maquettes' => [
                        'Créer un wireframe du dashboard',
                        'Choisir une palette de couleurs',
                        'Définir la typographie',
                        'Créer les maquettes des écrans principaux',
                        'Valider les maquettes avec le client',
                    ],
                    'Développement MVP' => [
                        'Mettre en place l’authentification',
                        'Créer le modèle Project',
                        'Créer le modèle Todo',
                        'Intégrer le front-end',
                        'Configurer la base de données',
                    ],
                    'Api & Backend' => [
                        'Mettre en place l’authentification',
                        'Ajouter les souscriptions',
                        'Gérer les erreurs API',
                        'Documenter l’API',
                    ],
                    'Tests et QA' => [
                        'Écrire des tests unitaires',
                        'Tester l’interface utilisateur',
                        'Corriger les bugs critiques',

                    ],
                ],
            ],
            'Nomad Tools' => [
                'description' => 'Suite d’outils pour travailleurs nomades.',
                'tasks' => [
                    'Étude de marché' => [
                        'Analyser les concurrents',
                        'Définir les besoins cibles',
                    ],
                    'Prototype App mobile' => [
                        'Créer écran d’accueil',
                        'Intégrer le GPS',
                    ],
                ],
            ],
            'BetaSite v2' => [
                'description' => 'Refonte complète du site institutionnel.',
                'tasks' => [
                    'Nouvelle arborescence' => [
                        'Revoir la navigation',
                        'Ajouter une section presse',
                    ],
                    'Accessibilité' => [
                        'Tester contraste WCAG',
                        'Rendre le site navigable au clavier',
                    ],
                ],
            ],
            'Portail RH' => [
                'description' => 'Portail interne pour les employés de Beta.',
                'tasks' => [
                    'Système de demandes de congé' => [
                        'Formulaire de demande',
                        'Validation par manager',
                    ],
                    'Gestion des documents' => [
                        'Upload de fiche de paie',
                    ],
                ],
            ],
            'Beta Analytics' => [
                'description' => 'Outil d’analyse des données de l’entreprise.',
                'tasks' => [
                    'Collecte des données' => [
                        'Intégrer les sources de données',
                        'Mettre en place un ETL',
                    ],
                    'Tableaux de bord' => [
                        'Créer un dashboard de performance',
                        'Ajouter des graphiques interactifs',
                    ],
                ],
            ],
            'Stellar CRM' => [
                'description' => 'Gestionnaire de relation client.',
                'tasks' => [
                    'Intégration des contacts' => [
                        'Importer les contacts existants',
                        'Mettre en place un formulaire de contact',
                    ],
                    'Suivi des opportunités' => [
                        'Créer un pipeline de ventes',
                        'Ajouter des notifications par email',
                    ],
                ],
            ],
        ];

        foreach ($betaProjects as $projectName => $details) {
            $project = Project::factory()->create([
                'name' => $projectName,
                'description' => $details['description'],
                'organization_id' => $beta->id,
                'user_id' => $users[0]->id,
                'status_id' => Status::inRandomOrder()->first()->id,
                'priority_id' => Priority::inRandomOrder()->first()->id,
            ]);

            foreach ($details['tasks'] as $main => $subs) {
                $parent = Todo::factory()->create([
                    'name' => $main,
                    'organization_id' => $beta->id,
                    'project_id' => $project->id,
                    'user_id' => $users[0]->id,
                    'status_id' => Status::inRandomOrder()->first()->id,
                    'priority_id' => Priority::inRandomOrder()->first()->id,
                    'is_trackable' => true,
                    'parent_id' => null,
                ]);

                Track::factory(random_int(0, 5))->create([
                    'user_id' => $users->random()->id,
                    'todo_id' => $parent->id,
                ]);
                foreach ($subs as $sub) {
                    $subTodo = Todo::factory()->create([
                        'name' => $sub,
                        'organization_id' => $beta->id,
                        'project_id' => $project->id,
                        'user_id' => $users[0]->id,
                        'status_id' => Status::inRandomOrder()->first()->id,
                        'priority_id' => Priority::inRandomOrder()->first()->id,
                        'is_trackable' => true,
                        'parent_id' => $parent->id,
                    ]);
                    Track::factory(random_int(0, 5))->create([
                        'user_id' => $users->random()->id,
                        'todo_id' => $subTodo->id,
                    ]);
                }
            }
        }


        $jeanProjectNames = [
            'Podcast Manager' => 'Outil de gestion d’épisodes de podcast.',
            'Tiny CRM' => 'Mini CRM personnel pour suivi de prospects.',
            'Note Board' => 'Application de prise de notes personnelle.',
            'Habitude Tracker' => 'Suivi des habitudes quotidiennes.',
            'Simplémo' => 'Système minimal de facturation en ligne.',
        ];

        foreach ($jeanProjectNames as $name => $desc) {
            $project = Project::factory()->create([
                'name' => $name,
                'description' => $desc,
                'organization_id' => null,
                'user_id' => $jean->id,
                'status_id' => Status::inRandomOrder()->first()->id,
                'priority_id' => Priority::inRandomOrder()->first()->id,
            ]);

            $todos = Todo::factory(rand(3, 6))->create([
                'organization_id' => null,
                'project_id' => $project->id,
                'user_id' => $jean->id,
                'status_id' => Status::inRandomOrder()->first()->id,
                'priority_id' => Priority::inRandomOrder()->first()->id,
                'is_trackable' => true,
                'parent_id' => null,
            ]);

            foreach ($todos as $todo) {
                if (rand(0, 1)) {
                    Todo::factory(rand(1, 3))->create([
                        'organization_id' => null,
                        'project_id' => $project->id,
                        'user_id' => $jean->id,
                        'status_id' => Status::inRandomOrder()->first()->id,
                        'priority_id' => Priority::inRandomOrder()->first()->id,
                        'is_trackable' => true,
                        'parent_id' => $todo->id,
                    ]);
                    Track::factory(random_int(0, 5))->create([
                        'user_id' => $jean->id,
                        'todo_id' => $todo->id,
                    ]);
                }
            }
        }


        $this->call([
            AdministratorSeeder::class,
        ]);

    }
}
