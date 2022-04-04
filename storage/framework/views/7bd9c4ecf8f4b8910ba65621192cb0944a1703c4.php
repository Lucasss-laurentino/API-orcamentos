<?php $__env->startSection('content'); ?>

<div class="container d-flex justify-content-center">
    <div class="row mt-5">
        <div class="col-12">
            <h1 class="mt-5 text-center"><?php echo e($plano_escolhido['nome']); ?></h1>
            <form class="transparente formulario_quantidade" style="height: 190px;">
                <?php echo csrf_field(); ?>
                <div class="form-group m-4 pt-3">
                    <label for="exampleInputEmail1">Quantidade de pessoas a participar do plano</label>
                    <input type="number" name="quantidade" class="form-control" id="quantidade" placeholder="1" min="1">
                </div>
                <div class="form-group m-4 text-center">
                    <button type="submit" id="enviar_quantidade" class="btn btn-danger mb-4" style="width: 60%">Confirmar</button>
                </div>
                <div class="form-group m-4 text-center">
                    <p class="text-danger" id="erro_quantidade"></p>
                </div>
            </form>
            <form class="transparente d-none formulario_dados">
                <?php echo csrf_field(); ?>
                <div class="form-group m-4">
                    <label for="exampleInputEmail1">Nome</label>
                    <input type="text" class="form-control" name="nome" id="nome" aria-describedby="emailHelp" placeholder="Nome">
                </div>
                <div class="form-group m-4">
                    <label for="exampleInputPassword1">Data de Nascimento</label>
                    <input type="date" class="form-control" id="dataNascimento" name="dataNascimento">
                </div>
                <div class="form-group m-4 text-center">
                    <button type="submit" class="btn btn-danger mb-4" id="enviar" style="width: 60%">Enviar</button>
                </div>
                <div class="form-group m-4 text-center">
                    <p class="text-danger" id="erro_dados"></p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tr3m/projetos/planos/planos_de_saude/resources/views//cadastro.blade.php ENDPATH**/ ?>