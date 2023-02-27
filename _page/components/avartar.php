 <div class="dropdown">
     <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar"
         role="button" data-bs-toggle="dropdown" aria-expanded="false">
         <img src="./../../file/<?= $myself['file_user'] ?>" class="rounded-circle" height="25" width="25"
             loading="lazy" />
     </a>
     <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
         <li>
             <a class="dropdown-item" href="./../general/edit_profile.php">My profile</a>
         </li>
         <li>
             <a class="dropdown-item" href="./../../_system/logout.php">Logout</a>
         </li>
     </ul>
 </div>