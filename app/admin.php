<?php
session_start();
$_SESSION['admin'] = 'admin';
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
require_once 'dbconnect_admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add_circuit') {
            $desc = $_POST['description'] ?? '';
            $duree = $_POST['duree'] ?? null;
            $prix = $_POST['prix'] ?? null;
            $nb = $_POST['nb_places'] ?? null;
            $date = $_POST['date_depart'] ?? null;
            $ville_dep = $_POST['id_ville_dep'] ?? null;
            $ville_arr = $_POST['id_ville_arr'] ?? null;
            if ($date !== '') {
                $date = str_replace('T', ' ', $date);
            } else {
                $date = null;
            }
            $sth = $conn->prepare("INSERT INTO Circuit_Touristique (Description, Duree_Circuit, Prix_Inscription, Nb_Places_Dispo, Date_Depart, Id_Ville, Id_Ville_1) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $sth->execute([$desc, $duree, $prix, $nb, $date, $ville_dep, $ville_arr]);
            header('Location: admin.php');
            exit;
        }

        if ($action === 'edit_circuit') {
            $id = $_POST['id_circuit'];
            $desc = $_POST['description'] ?? '';
            $duree = $_POST['duree'] ?? null;
            $prix = $_POST['prix'] ?? null;
            $nb = $_POST['nb_places'] ?? null;
            $date = $_POST['date_depart'] ?? null;
            $ville_dep = $_POST['id_ville_dep'] ?? null;
            $ville_arr = $_POST['id_ville_arr'] ?? null;
            if ($date !== '') {
                $date = str_replace('T', ' ', $date);
            } else {
                $date = null;
            }
            $sth = $conn->prepare("UPDATE Circuit_Touristique SET Description=?, Duree_Circuit=?, Prix_Inscription=?, Nb_Places_Dispo=?, Date_Depart=?, Id_Ville=?, Id_Ville_1=? WHERE Id_Circuit_Touristique=?");
            $sth->execute([$desc, $duree, $prix, $nb, $date, $ville_dep, $ville_arr, $id]);
            header('Location: admin.php');
            exit;
        }

        if ($action === 'delete_circuit') {
            $id = $_POST['id_circuit'];
            $sth = $conn->prepare("DELETE FROM Circuit_Touristique WHERE Id_Circuit_Touristique=?");
            $sth->execute([$id]);
            header('Location: admin.php');
            exit;
        }

        if ($action === 'add_activitee') {
            $nom = $_POST['nom'] ?? '';
            $image = $_POST['image'] ?? '';
            $desc = $_POST['description'] ?? '';
            $cout = $_POST['cout'] ?? null;
            $id_type = $_POST['id_type'] ?? null;
            $id_ville = $_POST['id_ville'] ?? null;
            $sth = $conn->prepare("INSERT INTO Activitee (Nom, Image, Description, Cout_Visite, Id_Type, Id_Ville) VALUES (?, ?, ?, ?, ?, ?)");
            $sth->execute([$nom, $image, $desc, $cout, $id_type, $id_ville]);
            header('Location: admin.php');
            exit;
        }

        if ($action === 'edit_activitee') {
            $id = $_POST['id_activitee'];
            $nom = $_POST['nom'] ?? '';
            $image = $_POST['image'] ?? '';
            $desc = $_POST['description'] ?? '';
            $cout = $_POST['cout'] ?? null;
            $id_type = $_POST['id_type'] ?? null;
            $id_ville = $_POST['id_ville'] ?? null;
            $sth = $conn->prepare("UPDATE Activitee SET Nom=?, Image=?, Description=?, Cout_Visite=?, Id_Type=?, Id_Ville=? WHERE Id_Activitee=?");
            $sth->execute([$nom, $image, $desc, $cout, $id_type, $id_ville, $id]);
            header('Location: admin.php');
            exit;
        }

        if ($action === 'delete_activitee') {
            $id = $_POST['id_activitee'];
            $sth = $conn->prepare("DELETE FROM Activitee WHERE Id_Activitee=?");
            $sth->execute([$id]);
            header('Location: admin.php');
            exit;
        }

        if ($action === 'add_etape') {
            $ordre = $_POST['ordre'] ?? null;
            $date = $_POST['date_etape'] ?? null;
            $duree = $_POST['duree_etape'] ?? null;
            $id_circuit = $_POST['id_circuit'] ?? null;
            $id_activitee = $_POST['id_activitee'] ?? null;
            if ($date !== '') {
                $date = str_replace('T', ' ', $date);
            } else {
                $date = null;
            }
            $sth = $conn->prepare("INSERT INTO Etape (Ordre, Date_, Duree, Id_Circuit_Touristique, Id_Activitee) VALUES (?, ?, ?, ?, ?)");
            $sth->execute([$ordre, $date, $duree, $id_circuit, $id_activitee]);
            header('Location: admin.php');
            exit;
        }

        if ($action === 'edit_etape') {
            $id = $_POST['id_etape'];
            $ordre = $_POST['ordre'] ?? null;
            $date = $_POST['date_etape'] ?? null;
            $duree = $_POST['duree_etape'] ?? null;
            $id_circuit = $_POST['id_circuit'] ?? null;
            $id_activitee = $_POST['id_activitee'] ?? null;
            if ($date !== '') {
                $date = str_replace('T', ' ', $date);
            } else {
                $date = null;
            }
            $sth = $conn->prepare("UPDATE Etape SET Ordre=?, Date_=?, Duree=?, Id_Circuit_Touristique=?, Id_Activitee=? WHERE Id_Etape=?");
            $sth->execute([$ordre, $date, $duree, $id_circuit, $id_activitee, $id]);
            header('Location: admin.php');
            exit;
        }

        if ($action === 'delete_etape') {
            $id = $_POST['id_etape'];
            $sth = $conn->prepare("DELETE FROM Etape WHERE Id_Etape=?");
            $sth->execute([$id]);
            header('Location: admin.php');
            exit;
        }
    }
}

$sth = $conn->query("SELECT c.*, v1.Nom AS Ville_Depart, v2.Nom AS Ville_Arrivee FROM Circuit_Touristique c LEFT JOIN Ville v1 ON c.Id_Ville = v1.Id_Ville LEFT JOIN Ville v2 ON c.Id_Ville_1 = v2.Id_Ville ORDER BY c.Id_Circuit_Touristique DESC");
$circuits = $sth->fetchAll();

$sth = $conn->query("SELECT e.*, c.Description AS Circuit_Description, a.Nom AS Activitee_Nom FROM Etape e LEFT JOIN Circuit_Touristique c ON e.Id_Circuit_Touristique = c.Id_Circuit_Touristique LEFT JOIN Activitee a ON e.Id_Activitee = a.Id_Activitee ORDER BY e.Id_Etape DESC");
$etapes = $sth->fetchAll();

$sth = $conn->query("SELECT a.*, t.Type AS Type_Nom, v.Nom AS Ville_Nom FROM Activitee a LEFT JOIN Type t ON a.Id_Type = t.Id_Type LEFT JOIN Ville v ON a.Id_Ville = v.Id_Ville ORDER BY a.Id_Activitee DESC");
$activitees = $sth->fetchAll();

$sth = $conn->query("SELECT * FROM Ville ORDER BY Nom ASC");
$villes = $sth->fetchAll();

$sth = $conn->query("SELECT * FROM Type ORDER BY Type ASC");
$types = $sth->fetchAll();
?>
<!doctype html>
<html lang="fr" data-bs-theme="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Gestion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <main class="container py-4">
        <div class="text-center mb-4">
            <h1 class="fw-light">Panneau d'administration</h1>
            <p class="lead text-body-secondary">Gérer les circuits, étapes et activités</p>
        </div>

        <ul class="nav nav-pills mb-3" id="admin-tabs" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-link active" id="circuits-tab" data-bs-toggle="pill" data-bs-target="#circuits" type="button" role="tab">Circuits</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="etapes-tab" data-bs-toggle="pill" data-bs-target="#etapes" type="button" role="tab">Étapes</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="activites-tab" data-bs-toggle="pill" data-bs-target="#activites" type="button" role="tab">Activités</button></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="circuits" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4>Circuits</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddCircuit">Ajouter un circuit</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Description</th>
                                <th>Durée</th>
                                <th>Prix</th>
                                <th>Places</th>
                                <th>Date départ</th>
                                <th>Ville départ → arrivée</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($circuits as $c): ?>
                                <tr>
                                    <td><?php echo $c['Id_Circuit_Touristique']; ?></td>
                                    <td><?php echo htmlspecialchars($c['Description']); ?></td>
                                    <td><?php echo $c['Duree_Circuit']; ?> j</td>
                                    <td><?php echo $c['Prix_Inscription']; ?></td>
                                    <td><?php echo $c['Nb_Places_Dispo']; ?></td>
                                    <td><?php echo $c['Date_Depart']; ?></td>
                                    <td><?php echo htmlspecialchars($c['Ville_Depart']); ?> → <?php echo htmlspecialchars($c['Ville_Arrivee']); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalEditCircuit" data-id="<?php echo $c['Id_Circuit_Touristique']; ?>" data-description="<?php echo htmlspecialchars($c['Description'], ENT_QUOTES); ?>" data-duree="<?php echo $c['Duree_Circuit']; ?>" data-prix="<?php echo $c['Prix_Inscription']; ?>" data-nb="<?php echo $c['Nb_Places_Dispo']; ?>" data-date="<?php echo ($c['Date_Depart']) ? str_replace(' ', 'T', $c['Date_Depart']) : ''; ?>" data-ville_dep="<?php echo $c['Id_Ville']; ?>" data-ville_arr="<?php echo $c['Id_Ville_1']; ?>">Modifier</button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalDeleteCircuit" data-id="<?php echo $c['Id_Circuit_Touristique']; ?>">Supprimer</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="etapes" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4>Étapes</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddEtape">Ajouter une étape</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ordre</th>
                                <th>Date</th>
                                <th>Durée</th>
                                <th>Id_Circuit</th>
                                <th>Circuit</th>
                                <th>Activité</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($etapes as $e): ?>
                                <tr>
                                    <td><?php echo $e['Id_Etape']; ?></td>
                                    <td><?php echo $e['Ordre']; ?></td>
                                    <td><?php echo $e['Date_']; ?></td>
                                    <td><?php echo $e['Duree']; ?></td>
                                    <td><?php echo $e['Id_Circuit_Touristique']; ?></td>
                                    <td><?php echo htmlspecialchars($e['Circuit_Description']); ?></td>
                                    <td><?php echo htmlspecialchars($e['Activitee_Nom']); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalEditEtape" data-id="<?php echo $e['Id_Etape']; ?>" data-ordre="<?php echo $e['Ordre']; ?>" data-date="<?php echo ($e['Date_']) ? str_replace(' ', 'T', $e['Date_']) : ''; ?>" data-duree="<?php echo $e['Duree']; ?>" data-circuit="<?php echo $e['Id_Circuit_Touristique']; ?>" data-activitee="<?php echo $e['Id_Activitee']; ?>">Modifier</button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalDeleteEtape" data-id="<?php echo $e['Id_Etape']; ?>">Supprimer</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="activites" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4>Activités</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddActivitee">Ajouter une activité</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Type</th>
                                <th>Ville</th>
                                <th>Coût</th>
                                <th>Image (lien)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activitees as $a): ?>
                                <tr>
                                    <td><?php echo $a['Id_Activitee']; ?></td>
                                    <td><?php echo htmlspecialchars($a['Nom']); ?></td>
                                    <td><?php echo htmlspecialchars($a['Type_Nom']); ?></td>
                                    <td><?php echo htmlspecialchars($a['Ville_Nom']); ?></td>
                                    <td><?php echo $a['Cout_Visite']; ?></td>
                                    <?php if (isset($a['Image'])):
                                        echo '<td><img style="height: 8vw;" src="' . htmlspecialchars($a['Image']) . '" alt=""></td>';
                                    else:
                                        echo '<td>Aucune image</td>';
                                    endif; ?>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalEditActivitee" data-id="<?php echo $a['Id_Activitee']; ?>" data-nom="<?php echo htmlspecialchars($a['Nom'], ENT_QUOTES); ?>" data-type="<?php echo $a['Id_Type']; ?>" data-ville="<?php echo $a['Id_Ville']; ?>" data-cout="<?php echo $a['Cout_Visite']; ?>" <?php if (isset($a['Image'])): echo 'data-image="' . htmlspecialchars($a['Image'], ENT_QUOTES) . '"';
                                                                                                                                                                                                                                                                                                                                                                                                    else : echo 'data-image=""';
                                                                                                                                                                                                                                                                                                                                                                                                    endif; ?>" data-desc="<?php echo htmlspecialchars($a['Description'], ENT_QUOTES); ?>">Modifier</button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalDeleteActivitee" data-id="<?php echo $a['Id_Activitee']; ?>">Supprimer</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-body-secondary py-5">
        <div class="container">
            <p class="float-end mb-1"><a href="#">Back to top</a></p>
        </div>
    </footer>

    <!-- Modals Circuits -->
    <div class="modal fade" id="modalAddCircuit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <input type="hidden" name="action" value="add_circuit">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un circuit</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Description</label><textarea class="form-control" name="description" required></textarea></div>
                        <div class="row">
                            <div class="col mb-2"><label>Durée (jours)</label><input type="number" class="form-control" name="duree" min="1"></div>
                            <div class="col mb-2"><label>Prix</label><input type="number" step="0.01" class="form-control" name="prix"></div>
                        </div>
                        <div class="row">
                            <div class="col mb-2"><label>Nb places</label><input type="number" class="form-control" name="nb_places"></div>
                            <div class="col mb-2"><label>Date départ</label><input type="datetime-local" class="form-control" name="date_depart"></div>
                        </div>
                        <div class="row">
                            <div class="col mb-2"><label>Ville départ</label><select class="form-select" name="id_ville_dep"><?php foreach ($villes as $v) echo "<option value=\"{$v['Id_Ville']}\">" . htmlspecialchars($v['Nom']) . "</option>"; ?></select></div>
                            <div class="col mb-2"><label>Ville arrivée</label><select class="form-select" name="id_ville_arr"><?php foreach ($villes as $v) echo "<option value=\"{$v['Id_Ville']}\">" . htmlspecialchars($v['Nom']) . "</option>"; ?></select></div>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn btn-primary">Ajouter</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditCircuit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <input type="hidden" name="action" value="edit_circuit">
                    <input type="hidden" name="id_circuit" id="edit_id_circuit">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier le circuit</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Description</label><textarea class="form-control" name="description" id="edit_description" required></textarea></div>
                        <div class="row">
                            <div class="col mb-2"><label>Durée (jours)</label><input type="number" class="form-control" name="duree" id="edit_duree" min="1"></div>
                            <div class="col mb-2"><label>Prix</label><input type="number" step="0.01" class="form-control" name="prix" id="edit_prix"></div>
                        </div>
                        <div class="row">
                            <div class="col mb-2"><label>Nb places</label><input type="number" class="form-control" name="nb_places" id="edit_nb"></div>
                            <div class="col mb-2"><label>Date départ</label><input type="datetime-local" class="form-control" name="date_depart" id="edit_date"></div>
                        </div>
                        <div class="row">
                            <div class="col mb-2"><label>Ville départ</label><select class="form-select" name="id_ville_dep" id="edit_ville_dep"><?php foreach ($villes as $v) echo "<option value=\"{$v['Id_Ville']}\">" . htmlspecialchars($v['Nom']) . "</option>"; ?></select></div>
                            <div class="col mb-2"><label>Ville arrivée</label><select class="form-select" name="id_ville_arr" id="edit_ville_arr"><?php foreach ($villes as $v) echo "<option value=\"{$v['Id_Ville']}\">" . htmlspecialchars($v['Nom']) . "</option>"; ?></select></div>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn btn-primary">Enregistrer</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDeleteCircuit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <input type="hidden" name="action" value="delete_circuit">
                    <input type="hidden" name="id_circuit" id="delete_id_circuit">
                    <div class="modal-header">
                        <h5 class="modal-title">Supprimer le circuit</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">Voulez-vous vraiment supprimer ce circuit ?</div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn btn-danger">Supprimer</button></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modals Activitee -->
    <div class="modal fade" id="modalAddActivitee" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <input type="hidden" name="action" value="add_activitee">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter une activité</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Nom</label><input class="form-control" name="nom" required></div>
                        <div class="mb-2"><label>Image (lien)</label><input class="form-control" name="image" type="url"></div>
                        <div class="mb-2"><label>Description</label><textarea class="form-control" name="description"></textarea></div>
                        <div class="mb-2"><label>Coût</label><input class="form-control" name="cout" type="number" step="0.01"></div>
                        <div class="row">
                            <div class="col mb-2"><label>Type</label><select class="form-select" name="id_type"><?php foreach ($types as $t) echo "<option value=\"{$t['Id_Type']}\">" . htmlspecialchars($t['Type']) . "</option>"; ?></select></div>
                            <div class="col mb-2"><label>Ville</label><select class="form-select" name="id_ville"><?php foreach ($villes as $v) echo "<option value=\"{$v['Id_Ville']}\">" . htmlspecialchars($v['Nom']) . "</option>"; ?></select></div>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn btn-primary">Ajouter</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditActivitee" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <input type="hidden" name="action" value="edit_activitee">
                    <input type="hidden" name="id_activitee" id="edit_id_activitee">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier l'activité</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Nom</label><input class="form-control" name="nom" id="edit_nom" required></div>
                        <div class="mb-2"><label>Image (lien)</label><input class="form-control" name="image" id="edit_image" type="url"></div>
                        <div class="mb-2"><label>Description</label><textarea class="form-control" name="description" id="edit_desc"></textarea></div>
                        <div class="mb-2"><label>Coût</label><input class="form-control" name="cout" id="edit_cout" type="number" step="0.01"></div>
                        <div class="row">
                            <div class="col mb-2"><label>Type</label><select class="form-select" name="id_type" id="edit_type"><?php foreach ($types as $t) echo "<option value=\"{$t['Id_Type']}\">" . htmlspecialchars($t['Type']) . "</option>"; ?></select></div>
                            <div class="col mb-2"><label>Ville</label><select class="form-select" name="id_ville" id="edit_ville"><?php foreach ($villes as $v) echo "<option value=\"{$v['Id_Ville']}\">" . htmlspecialchars($v['Nom']) . "</option>"; ?></select></div>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn btn-primary">Enregistrer</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDeleteActivitee" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <input type="hidden" name="action" value="delete_activitee">
                    <input type="hidden" name="id_activitee" id="delete_id_activitee">
                    <div class="modal-header">
                        <h5 class="modal-title">Supprimer l'activité</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">Voulez-vous vraiment supprimer cette activité ?</div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn btn-danger">Supprimer</button></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modals Etape -->
    <div class="modal fade" id="modalAddEtape" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <input type="hidden" name="action" value="add_etape">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter une étape</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Ordre</label><input class="form-control" name="ordre" type="number"></div>
                        <div class="mb-2"><label>Date</label><input class="form-control" name="date_etape" type="datetime-local"></div>
                        <div class="mb-2"><label>Durée</label><input class="form-control" name="duree_etape" type="number"></div>
                        <div class="mb-2"><label>Circuit</label><select class="form-select" name="id_circuit"><?php foreach ($circuits as $c) echo "<option value=\"{$c['Id_Circuit_Touristique']}\">" . htmlspecialchars(substr($c['Id_Circuit_Touristique'] . ' - ' . $c['Description'], 0, 60)) . "...</option>"; ?></select></div>
                        <div class="mb-2"><label>Activité</label><select class="form-select" name="id_activitee"><?php foreach ($activitees as $a) echo "<option value=\"{$a['Id_Activitee']}\">" . htmlspecialchars($a['Nom']) . "</option>"; ?></select></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn btn-primary">Ajouter</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditEtape" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <input type="hidden" name="action" value="edit_etape">
                    <input type="hidden" name="id_etape" id="edit_id_etape">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier l'étape</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2"><label>Ordre</label><input class="form-control" name="ordre" id="edit_ordre" type="number"></div>
                        <div class="mb-2"><label>Date</label><input class="form-control" name="date_etape" id="edit_date_etape" type="datetime-local"></div>
                        <div class="mb-2"><label>Durée</label><input class="form-control" name="duree_etape" id="edit_duree_etape" type="number"></div>
                        <div class="mb-2"><label>Circuit</label><select class="form-select" name="id_circuit" id="edit_circuit"><?php foreach ($circuits as $c) echo "<option value=\"{$c['Id_Circuit_Touristique']}\">" . htmlspecialchars(substr($c['Description'], 0, 60)) . "...</option>"; ?></select></div>
                        <div class="mb-2"><label>Activité</label><select class="form-select" name="id_activitee" id="edit_activitee"><?php foreach ($activitees as $a) echo "<option value=\"{$a['Id_Activitee']}\">" . htmlspecialchars($a['Nom']) . "</option>"; ?></select></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn btn-primary">Enregistrer</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDeleteEtape" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <input type="hidden" name="action" value="delete_etape">
                    <input type="hidden" name="id_etape" id="delete_id_etape">
                    <div class="modal-header">
                        <h5 class="modal-title">Supprimer l'étape</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">Voulez-vous vraiment supprimer cette étape ?</div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn btn-danger">Supprimer</button></div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var modalEditCircuit = document.getElementById('modalEditCircuit');
        modalEditCircuit.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            document.getElementById('edit_id_circuit').value = button.getAttribute('data-id') || '';
            document.getElementById('edit_description').value = button.getAttribute('data-description') || '';
            document.getElementById('edit_duree').value = button.getAttribute('data-duree') || '';
            document.getElementById('edit_prix').value = button.getAttribute('data-prix') || '';
            document.getElementById('edit_nb').value = button.getAttribute('data-nb') || '';
            document.getElementById('edit_date').value = button.getAttribute('data-date') || '';
            document.getElementById('edit_ville_dep').value = button.getAttribute('data-ville_dep') || '';
            document.getElementById('edit_ville_arr').value = button.getAttribute('data-ville_arr') || '';
        });
        var modalDeleteCircuit = document.getElementById('modalDeleteCircuit');
        modalDeleteCircuit.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            document.getElementById('delete_id_circuit').value = button.getAttribute('data-id') || '';
        });

        var modalEditActivitee = document.getElementById('modalEditActivitee');
        modalEditActivitee.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            document.getElementById('edit_id_activitee').value = button.getAttribute('data-id') || '';
            document.getElementById('edit_nom').value = button.getAttribute('data-nom') || '';
            document.getElementById('edit_image').value = button.getAttribute('data-image') || '';
            document.getElementById('edit_desc').value = button.getAttribute('data-desc') || '';
            document.getElementById('edit_cout').value = button.getAttribute('data-cout') || '';
            document.getElementById('edit_type').value = button.getAttribute('data-type') || '';
            document.getElementById('edit_ville').value = button.getAttribute('data-ville') || '';
        });
        var modalDeleteActivitee = document.getElementById('modalDeleteActivitee');
        modalDeleteActivitee.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            document.getElementById('delete_id_activitee').value = button.getAttribute('data-id') || '';
        });

        var modalEditEtape = document.getElementById('modalEditEtape');
        modalEditEtape.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            document.getElementById('edit_id_etape').value = button.getAttribute('data-id') || '';
            document.getElementById('edit_ordre').value = button.getAttribute('data-ordre') || '';
            document.getElementById('edit_date_etape').value = button.getAttribute('data-date') || '';
            document.getElementById('edit_duree_etape').value = button.getAttribute('data-duree') || '';
            document.getElementById('edit_circuit').value = button.getAttribute('data-circuit') || '';
            document.getElementById('edit_activitee').value = button.getAttribute('data-activitee') || '';
        });
        var modalDeleteEtape = document.getElementById('modalDeleteEtape');
        modalDeleteEtape.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            document.getElementById('delete_id_etape').value = button.getAttribute('data-id') || '';
        });
    </script>
</body>

</html>