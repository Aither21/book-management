import { React, useState, useEffect } from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import { Header } from './pages/header';
import { Home } from './pages/home';
import { PreUserRegisterForm } from './pages/pre_user_register_form';
import { Login } from './pages/login';
import { BookList } from './pages/book_list';
import { BookShow } from './pages/book_show';
import { AdminBookList } from './pages/admin_book_list';
import { NotFound } from './pages/not_found';

const App = () => {
  // const sortOutAuthentication = () => {
  //   const authData= document.cookie;
  //   const correntPath= location.pathname;
  //   const authPathes = ['/book/list', '/book', '/admin/book/list'];
  //   const someResult = authPathes.some((authPath) => {
  //     return authPath === correntPath;
  //   });
  //   console.log(authData)
  //   console.log(authData.includes('XSRF-'))
  //   if(someResult && !authData.includes('XSRF-')){
  //     return window.location.href = "/login";
  //   }
  // }
  // useEffect(() => {
  //   sortOutAuthentication();
  // },[]);
  return(
      <BrowserRouter>
        <>
            <Header screenName={'Header'}/>
          <div className="flex flex-col justify-center items-center">
            <Routes>
                <Route path='/' element={ <Home explanation = {'※開発用に仮で作成しました'} linkPreUserRegisterForm = '仮会員登録画面へ' />} />
                <Route path='/pre_user/register' element={<PreUserRegisterForm />} />
                <Route path='/login' element={<Login />} />
                <Route path='/book/list' element={<BookList />} />
                <Route path='/book' element={<BookShow />} />
                <Route path='/admin/book/list' element={<AdminBookList />} />
                <Route path='*' element={<NotFound />} />
            </Routes>
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
