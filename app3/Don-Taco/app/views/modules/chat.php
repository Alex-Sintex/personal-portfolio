<?php require PATH_APP . '/views/header/header.php'; ?>
<div id="layoutSidenav">
    <?php require PATH_APP . '/views/navigation/navigation.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">CHAT</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="<?= PATH_URL; ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Chat</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        CHATTING
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        MENSAJERÍA
                    </div>
                    <div class="card-body">
                        <!-- char-area -->
                        <section class="message-area">
                            <div class="container expanded">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="chat-area">
                                            <!-- chatlist -->
                                            <div class="chatlist">
                                                <div class="modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="chat-header">
                                                            <div class="msg-search">
                                                                <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search" aria-label="search">
                                                                <a class="add" href="#"><img class="img-fluid" src="<?= PATH_URL ?>/img/assets/add.svg" alt="add"></a>
                                                            </div>

                                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                                <li class="nav-item" role="presentation">
                                                                    <button class="nav-link active" id="Open-tab" data-bs-toggle="tab" data-bs-target="#Open" type="button" role="tab" aria-controls="Open" aria-selected="true">Online</button>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <button class="nav-link" id="Closed-tab" data-bs-toggle="tab" data-bs-target="#Closed" type="button" role="tab" aria-controls="Closed" aria-selected="false">Offline</button>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="modal-body">
                                                            <!-- tab chat-list for online users -->
                                                            <div class="chat-lists">
                                                                <div class="tab-content" id="myTabContent">
                                                                    <div class="tab-pane fade show active" id="Open" role="tabpanel" aria-labelledby="Open-tab">
                                                                        <!-- chat-list -->
                                                                        <div id="Online" class="chat-list">
                                                                            <a href="#" class="d-flex align-items-center">
                                                                                <div class="flex-shrink-0">
                                                                                </div>
                                                                                <div class="flex-grow-1 ms-3">
                                                                                    <h3>Mehedi Hasan</h3>
                                                                                    <p>front end developer</p>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <!-- chat-list -->
                                                                    </div>
                                                                    <div class="tab-pane fade" id="Closed" role="tabpanel" aria-labelledby="Closed-tab">

                                                                        <!-- tab chat-list for offline users -->
                                                                        <div id="Offline" class="chat-list">
                                                                            <a href="#" class="d-flex align-items-center">
                                                                                <div class="flex-shrink-0">
                                                                                </div>
                                                                                <div class="flex-grow-1 ms-3">
                                                                                    <h3>Mehedi Hasan</h3>
                                                                                    <p>front end developer</p>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <!-- chat-list -->
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <!-- chat-list -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- chatlist -->

                                            <!-- chatbox -->
                                            <div class="chatbox">
                                                <div class="modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="msg-head">
                                                            <div class="row">
                                                                <!-- Header del chat -->
                                                                <div class="col-8" id="chatHeader">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="chat-icon">
                                                                            <img class="img-fluid" src="<?= PATH_URL; ?>img/assets/arroleftt.svg" alt="image title">
                                                                        </span>
                                                                        <div class="flex-shrink-0">
                                                                            <img id="chatUserAvatar" class="img-fluid" src="/uploads/default-avatar.png" alt="user img">
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-3">
                                                                            <h3 id="chatUsername">No user selected</h3>
                                                                            <p id="chatStatus">online/offline</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <ul class="moreoption">
                                                                        <li class="navbar nav-item dropdown">
                                                                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                                                                            <ul class="dropdown-menu">
                                                                                <li><a class="dropdown-item d-flex align-items-center" href="#" id="openBackgroundSelector">Fondos chat</a></li>
                                                                                <li>
                                                                                    <hr class="dropdown-divider">
                                                                                </li>
                                                                                <li><a class="dropdown-item" id="resetBackground">Quitar fondo</a></li>
                                                                            </ul>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="bg" class="modal-body">
                                                            <div class="msg-body">
                                                                <div class="chat-messages"></div>
                                                            </div>
                                                        </div>

                                                        <div class="chat__conversation-panel">
                                                            <div class="chat__conversation-panel__container">
                                                                <button class="chat__conversation-panel__button panel-item btn-icon add-file-button">
                                                                    <svg class="feather feather-plus sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                                                    </svg>
                                                                </button>
                                                                <span id="chatFileName" style="margin-left: 10px; font-size: 0.9em; color: #555;"></span>
                                                                <input type="file" id="chatFileInput" accept=".pdf" style="display: none;">
                                                                <button class="chat__conversation-panel__button panel-item btn-icon emoji-button">
                                                                    <svg class="feather feather-smile sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                        <circle cx="12" cy="12" r="10"></circle>
                                                                        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                                                        <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                                                        <line x1="15" y1="9" x2="15.01" y2="9"></line>
                                                                    </svg>
                                                                </button>
                                                                <div id="emoji-picker" class="emoji-picker" style="display: none;">
                                                                    <span>😀</span> <span>😁</span> <span>😂</span> <span>🤣</span> <span>😃</span>
                                                                    <span>😄</span> <span>😅</span> <span>😆</span> <span>😉</span> <span>😊</span>
                                                                    <span>😎</span> <span>😍</span> <span>😘</span> <span>😜</span> <span>😢</span>
                                                                    <span>😡</span> <span>😱</span> <span>👍</span> <span>👎</span> <span>🙌</span>
                                                                    <span>🎉</span> <span>❤️</span> <span>🧠</span> <span>🐱</span> <span>🐶</span>
                                                                    <span>🍕</span> <span>🍔</span> <span>⚽</span> <span>🚀</span> <span>🎮</span>
                                                                </div>
                                                                <input type="hidden" id="currentUserId" value="<?= $_SESSION['user_id'] ?>">
                                                                <input id="messageInput" class="chat__conversation-panel__input panel-item" placeholder="Type a message...">
                                                                <button id="sendBtn" class="chat__conversation-panel__button panel-item btn-icon send-message-button">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" data-reactid="1036">
                                                                        <line x1="22" y1="2" x2="11" y2="13"></line>
                                                                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- chatbox -->

                                    </div>
                                </div>
                            </div>
                    </div>
                    </section>
                    <!-- char-area -->
                </div>
            </div>
        </main>
        <!-- Modal -->
        <div class="modal fade" id="newChatModal" tabindex="-1" role="dialog" aria-labelledby="newChatModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newChatModalLabel">Selecciona un usuario para iniciar el chat</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="userList" class="list-group"></ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Background Selector Modal -->
        <div class="modal fade" id="backgroundSelectorModal" tabindex="-1" aria-labelledby="backgroundSelectorLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="backgroundSelectorLabel">Selecciona un fondo para el chat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="background-options d-flex flex-wrap gap-3">
                            <!-- Example splash images, replace URLs with your actual splash image URLs -->
                            <img src="<?= PATH_URL ?>/img/chat/bg1.png" class="background-thumb" alt="Fondo 1" style="width:100px; cursor:pointer;" />
                            <img src="<?= PATH_URL ?>/img/chat/bg2.png" class="background-thumb" alt="Fondo 2" style="width:100px; cursor:pointer;" />
                            <img src="<?= PATH_URL ?>/img/chat/bg3.png" class="background-thumb" alt="Fondo 3" style="width:100px; cursor:pointer;" />
                            <img src="<?= PATH_URL ?>/img/chat/bg4.png" class="background-thumb" alt="Fondo 4" style="width:100px; cursor:pointer;" />
                            <img src="<?= PATH_URL ?>/img/chat/bg5.png" class="background-thumb" alt="Fondo 5" style="width:100px; cursor:pointer;" />
                            <img src="<?= PATH_URL ?>/img/chat/bg6.png" class="background-thumb" alt="Fondo 6" style="width:100px; cursor:pointer;" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php require PATH_APP . '/views/footer/footer.php'; ?>
    </div>