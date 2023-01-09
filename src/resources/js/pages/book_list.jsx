import { React, useState, useEffect } from "react";
import axios from "axios";
import { BookTable } from '../components/book_table';
import { Pagenation } from '../components/pagenation';
import { SearchBar } from '../components/search_bar';
import { SortBar } from '../components/sort_bar';

const BookList = () => {
	const [bookListState, setBookListState] = useState({});
	const [pageCountState, setPageCountState] = useState(1);
	const [correntPageState, setCorrentPageState] = useState({ selected: 0 });

	//ソート処理
	const [sortState, setSortState] = useState(1);
  const changeSortState = (event) => {
		setSortState(event.target.value);
	}

	//検索処理
	const [searchState, setSearchState] = useState('');
  const changeSearchState = (event) => {
		setSearchState(event.target.value);
	}


	const getBookRequest = async () => {
		await axios.get('/sanctum/csrf-cookie').then(() => {
			axios.get(`/api/v1/book?page=${correntPageState.selected + 1}&sort=${sortState}&freeword=${searchState}`)
			.then(data => {
				setBookListState(data.data.data);
				setPageCountState(data.data.meta.last_page);
			})
			.catch(error => {
				console.error(`/api/v1/book:${error}`);
			})
		})
		.catch(error => {
			console.error(`sanctumError:${error}`);
		})
	}
	useEffect(() => {
		getBookRequest();
	}, [correntPageState, sortState])

	return(
		<>
		<div className="flex flex-col w-full">
			<SortBar changeSortState={changeSortState} />
			<SearchBar changeSearchState={changeSearchState} getBookRequest={getBookRequest} />
			<BookTable lists={bookListState} />
			<Pagenation pageCount={pageCountState} setCorrentPageState={setCorrentPageState} />
		</div>
		</>
	);
}
export { BookList };