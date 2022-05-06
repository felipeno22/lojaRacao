<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Produtos
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Produto</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/products/<?php echo htmlspecialchars( $product["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label for="desproduct">Nome da produto</label>
              <input type="text" class="form-control" id="desproduct" name="desproduct" placeholder="Digite o nome do produto" value="<?php echo htmlspecialchars( $product["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            
            <div class="form-group">
              <label for="desbrand">Marca</label>
              <input type="text" class="form-control" id="desbrand" name="desbrand" placeholder="Digite a marca" value="<?php echo htmlspecialchars( $product["desbrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
			
			
			<div class="form-outline">
			   <label class="form-label" for="description">Descrição</label>
			  <textarea class="form-control" placeholder="Fale sobre a ração" id="description" name="description" rows="4"  ><?php echo htmlspecialchars( $product["description"], ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea>
			</div>
			
			<div class="form-group">
              <label for="desagedog">Idade</label>
              <input type="text" class="form-control" id="desagedog" name="desagedog" placeholder="ex: adulto, filhote e sênior" value="<?php echo htmlspecialchars( $product["desagedog"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
			
			<div class="form-group">
              <label for="desporteraca">Porte de raça</label>
              <input type="text" class="form-control" id="desporteraca" name="desporteraca" placeholder="ex: grande, pequeno, mini...." value="<?php echo htmlspecialchars( $product["desporteraca"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
			
          
			<div class="form-group">
              <label for="vlweight">Peso</label>
              <input type="text" class="form-control" id="vlweight" name="vlweight" placeholder="0.00" value="<?php echo htmlspecialchars( $product["vlweight"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
			
			
			<div class="form-group">
              <label for="desline">Linha</label>
              <input type="text" class="form-control" id="desline" name="desline" placeholder="ex: super premium, premium, standard...."  value="<?php echo htmlspecialchars( $product["desline"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
			
			
            <div class="form-group">
              <label for="file">Foto</label>
              <input type="file" class="form-control" id="file" name="file" value="<?php echo htmlspecialchars( $product["vlweight"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              <div class="box box-widget">
                <div class="box-body">
                  <img class="img-responsive" id="image-preview" src="<?php echo htmlspecialchars( $product["desphoto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="Photo">
                </div>
              </div>
            </div>
          </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
document.querySelector('#file').addEventListener('change', function(){
  
  var file = new FileReader();

  file.onload = function() {
    
    document.querySelector('#image-preview').src = file.result;

  }

  file.readAsDataURL(this.files[0]);

});
</script>