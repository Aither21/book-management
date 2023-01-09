import { React } from "react";
import ReactPaginate from 'react-paginate';


const Pagenation = (props) => {
  
  return (
    <div>
      <ReactPaginate
        pageCount = {props.pageCount} //全ページ数
        pageRangeDisplayed = {5} // 現在のページの前後をいくつ表示させるか
        marginPagesDisplayed = {1} // 先頭と末尾に表示するページ数
        className = "flex justify-center items-center" //一番外側のタグ
        containerClassName="" // ul(pagination本体)
        pageClassName = "border py-1 px-1 mx-1" // li
        pageLinkClassName = "p-2 text-indigo-500" // a
        activeClassName = "text-black-500" // active.li
        activeLinkClassName = "text-black" // active.li < a

        //前へ　次へ
        previousLabel = "< 前へ" // a
        previousClassName = "hidden border text-indigo-500 mr-5 py-1 px-2" // li //いらないので非表示
        nextLabel = "次へ >" // a
        nextClassName = "hidden border text-indigo-500 ml-4 py-1 px-2" // li　//いらないので非表示

        //イベント
        onPageChange={props.setCorrentPageState}
      />
    </div>
  );
}

export { Pagenation };