import React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import { Header } from './pages/header';
import { Home } from './pages/home';
import { PreUserRegisterForm } from './pages/pre_user_register_form';
import { Login } from './pages/login_form';
import { Book } from './pages/book';
import { NotFound } from './pages/not_found';

const App = () => {
  return(
      <BrowserRouter>
        <>
            <Header screenName={'Header'}/>
          <div className="flex flex-col justify-center items-center">
            <Routes>
                <Route path='/' element={ <Home explanation = {'※開発用に仮で作成しました'} linkPreUserRegisterForm = '仮会員登録画面へ' />} />
                <Route path='/pre_user/register' element={<PreUserRegisterForm />} />
                <Route path='/login' element={<Login />} />
                <Route path='/book/list' element={<Book />} />
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
