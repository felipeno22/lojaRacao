<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Produtos
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/admin/categories">Categorias</a></li>
    <li class="active"><a href="/admin/categories/create">Cadastrar</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Novo Produto</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/products/create" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="desproduct">Nome da ração</label>
              <input type="text" class="form-control" id="desproduct" name="desproduct" placeholder="Digite o nome do ração">
            </div>
			 
			 <div class="form-group">
              <label for="desbrand">Marca</label>
              <input type="text" class="form-control" id="desbrand" name="desbrand" placeholder="Digite a marca">
            </div>
			 
			
			<div class="form-outline">
			   <label class="form-label" for="description">Descrição</label>
			  <textarea class="form-control" placeholder="Fale sobre a ração" id="description" name="description" rows="4"></textarea>
			</div>
			
			<div class="form-group">
              <label for="desagedog">Idade</label>
              <input type="text" class="form-control" id="desagedog" name="desagedog" placeholder="ex: adulto, filhote e sênior">
            </div>
			
			<div class="form-group">
              <label for="desporteraca">Porte da raça</label>
              <input type="text" class="form-control" id="desporteraca" name="desporteraca" placeholder="ex: grande, pequeno, mini....">
            </div>
			
			
			
            <div class="form-group">
              <label for="vlprice">Preço</label>
              <input type="number" class="form-control" id="vlprice" name="vlprice" step="0.01" placeholder="0.00">
            </div>
			
			<div class="form-group">
              <label for="vlweight">Peso</label>
              <input type="text" class="form-control" id="vlweight" name="vlweight" placeholder="0.00">
            </div>
			
			<div class="form-group">
              <label for="desline">Linha</label>
              <input type="text" class="form-control" id="desline" name="desline" placeholder="ex: super premium, premium, standard....">
            </div>
            
			  <div class="form-group">
              <label for="desurl">URL</label>
              <input type="text" class="form-control" id="desurl" name="desurl" placeholder="">
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success">Cadastrar</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->