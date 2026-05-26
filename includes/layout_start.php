<?php include 'header.php'; ?>

<div class="wrapper">

    <?php include 'sidebar.php'; ?>

    <div class="main-panel">

        <?php include 'navbar.php'; ?>

        <div class="content">
            <div class="container-fluid">


                 <!-- ALERTAS -->
                <!-- @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif -->



                <?php if(isset($breadcrumb)): ?>
                    <div class="content-header mb-3">
                        <?= $breadcrumb ?>
                    </div>
                <?php endif; ?>
