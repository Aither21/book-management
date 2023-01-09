import { React } from "react";

const SearchBar = (props) => {
  
  return (
    <div className="flex w-full justify-center items-end mt-5">
      <div className="relative mr-4 w-1/2">
        <input type="text" name="search_str" 
        className="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:ring-2 focus:ring-indigo-200 
        focus:bg-transparent focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 
        transition-colors duration-200 ease-in-out" 
        onChange={(event) => props.changeSearchState(event)} />
      </div>
      <button className="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg"
      onClick={props.getBookRequest}>
        検索
      </button>
    </div>
);
}

export { SearchBar };