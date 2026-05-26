<?php include __DIR__ . '/../../includes/layout_start.php'; ?>
<div style="display: flex; gap: 30px; justify-content: center; margin-top: 40px; flex-wrap: wrap;">
    <?php if (!empty($empresas)): ?>
        <?php foreach($empresas as $empresa): ?>
            <a href="/cotizaciones2/pages/empresas/pedidos.php?id=<?= $empresa->id ?>" style="text-decoration: none; color: inherit;">
                <div style="
                    width: 180px;
                    height: 180px;
                    border: 1px solid #ccc;
                    border-radius: 12px;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    transition: 0.2s;
                    cursor: pointer;
                    background: white;
                "
                onmouseover="this.style.transform='scale(1.05)'"
                onmouseout="this.style.transform='scale(1)'">
                    <img
                        src="<?= !empty($empresa->logo)
                            ? '/cotizaciones2/public/images/empresas/' . $empresa->logo
                            : '/cotizaciones2/public/images/default.png' ?>"
                        style="width: 80px; height: 80px; object-fit: contain; margin-bottom: 10px;"
                    >
                    <strong><?= $empresa->nombre ?></strong>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay empresas</p>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/../../includes/layout_end.php'; ?>