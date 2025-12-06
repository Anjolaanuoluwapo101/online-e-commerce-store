<div class="row fade-in">
    <div class="col-md-12">
        <h2 class="mb-4">Tags</h2>
        
        <div class="mb-4">
            <a href="/admin/tags/create" class="btn-admin">
                <i class="fa fa-plus me-1"></i> Add New Tag
            </a>
        </div>
        
        <?php if (empty($tags)): ?>
            <div class="alert alert-info">
                <p>No tags found.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tags as $tag): ?>
                            <tr class="hover-lift">
                                <td><?= $tag['id'] ?></td>
                                <td><?= $tag['name'] ?></td>
                                <td><?= $tag['slug'] ?></td>
                                <td><?= $tag['description'] ?? 'No description' ?></td>
                                <td>
                                    <a href="/admin/tags/<?= $tag['id'] ?>/edit" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="/admin/tags/<?= $tag['id'] ?>/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this tag?')">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>