<?php $__env->startSection('content'); ?>

<div class="container d-flex justify-content-center">
    <div class="row mt-5">
        <div class="col-12 mt-3">
            <h1 class="text-center"><?php echo e($orcamento['plano']); ?></h1>
            <table class="table transparente mt-4" style="height: 250px;">
                <thead>
                    <tr>
                        <th scope="col" class="p-2"><h3>Nome</h3></th>
                        <th scope="col" class="p-2"><h3>Idade</h3></th>
                        <th scope="col" class="p-2"><h3>Individual</h3></th>
                        <th scope="col" class="p-2"><h3>Total</h3></th>
                    </tr>
                </thead>
                <tbody>
                <?php for($contador = 0; $contador < count($orcamento['nomes']); $contador ++): ?>
                    <tr>
                        <td class="p-2 pb-0"><h6><?php echo e($orcamento['nomes'][$contador]); ?></h6></td>
                        <td class="p-2 text-center"><h6><?php echo e($orcamento['idades'][$contador]); ?></h6></td>
                        <td class="p-2 text-center"><h6>R$ <?php echo e($orcamento['individual'][$contador]); ?></h6></td>
                <?php endfor; ?>
                        <td class="p-2 text-center"><h6>R$ <?php echo e($orcamento['total']); ?></h6></td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <a href="/" class="text-danger">Voltar a página inicial</a>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lucas/api/api_orcamento/resources/views/proposta.blade.php ENDPATH**/ ?>