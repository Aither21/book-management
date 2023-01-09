import { React, useState, useEffect } from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import { Header } from './pages/header';
import { SidePanel } from "./components/side_panel";
import { Home } from './pages/home';
import { PreUserRegisterForm } from './pages/pre_user_register_form';
import { Login } from './pages/login';
import { BookList } from './pages/book_list';
import { BookShow } from './pages/book_show';
import { AdminBookBorrowList } from './pages/admin_book_borrow_list';
import { AdminBookReturnList } from './pages/admin_book_return_list';
import { AdminBookLentList } from './pages/admin_book_lent_list';
import { NotFound } from './pages/not_found';

const App = () => {
  const verifyAuthentication = () => {
    const cookieData= document.cookie;
    const correntPath= location.pathname;
    const requiredGeneralPathes = ['/book/list', '/book', '/admin/book/list'];
    const requiredAdminPathes = 
    ['/admin/book/borrow/list', '/admin/book/borrow/list', '/admin/book/return/list', '/admin/book/rent/list'];
    const collatePathGeneralResult = requiredGeneralPathes.some((requiredGeneralPath) => {
      return requiredGeneralPath === correntPath;
    });
    const collatePathAdminResult = requiredAdminPathes.some((requiredAdminPath) => {
      return requiredAdminPath === correntPath;
    });
    //一般ユーザーと管理者が見れる画面の時、「CredentialsAfterLogin」か「AdminCredentialsAfterLogin」がなかったらログイン遷移
    if(collatePathGeneralResult && (!cookieData.includes('CredentialsAfterLogin') && !cookieData.includes('AdminCredentialsAfterLogin'))){
      return window.location.href = "/login";
    }
    //管理者のみ見れる画面の時、「AdminCredentialsAfterLogin」がなかったらログイン遷移
    if(collatePathAdminResult && !cookieData.includes('AdminCredentialsAfterLogin')){
      return window.location.href = "/login";
    }
  }
  useEffect(() => {
    verifyAuthentication();
  },[]);

  return(
      <BrowserRouter>
        <>
          <Header />
          <div className="flex justify-center w-full">
            <SidePanel />
            <div className="flex flex-col justify-center items-center w-full">
              <Routes>
                  <Route path='/' element={ <Home explanation = {'※開発用に仮で作成しました'} linkPreUserRegisterForm = '仮会員登録画面へ' />} />
                  <Route path='/pre_user/register' element={<PreUserRegisterForm />} />
                  <Route path='/login' element={<Login />} />
                  <Route path='/book/list' element={<BookList />} />
                  <Route path='/book' element={<BookShow />} />
                  <Route path='/admin/book/borrow/list' element={<AdminBookBorrowList />} />
                  <Route path='/admin/book/return/list' element={<AdminBookReturnList />} />
                  <Route path='/admin/book/lent/list' element={<AdminBookLentList />} />
                  <Route path='*' element={<NotFound />} />
              </Routes>
            </div>
          </div>
        </>
      </BrowserRouter>
  );
}

// function registerPreUser() {
//   const [SearchParams] = useSearchParams();
//   const page = SearchParams.get('page')
//   return(
//     <h2>仮会員登録</h2>
//   );
// }

const root = ReactDOM.createRoot(document.getElementById("app"));
root.render(<App />);
