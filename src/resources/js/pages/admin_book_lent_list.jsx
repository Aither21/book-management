import { React, useState, useEffect, useRef } from "react";
import axios from "axios";
import { AdminBookTableLent } from '../components/admin_book_table_lent';
import { Pagenation } from '../components/pagenation';
import { SearchBar } from '../components/search_bar';
import { SortBar } from '../components/sort_bar';

const AdminBookLentList = () => {
	const [bookListState, setBookListState] = useState({});
	const [pageCountState, setPageCountState] = useState(1);
	const [correntPageState, setCorrentPageState] = useState({ selected: 0 });

	const isFirstRender = useRef(false);
	useEffect(() => {
		isFirstRender.current = true;
	})

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
		await axios.get('/sanctum/csrf-cookie').then((data) => {
			const sanctumStatus = data.status;
			console.log(`sanctumStatus:${sanctumStatus}`)
			if(sanctumStatus !== 204){
				location.href='/login';
			}
			else {
				axios.get(`/api/v1/book-management?page=${correntPageState.selected + 1}&status=2&sort=${sortState}&freeword=${searchState}`)
				.then(data => {
					setBookListState(data.data.data);
					setPageCountState(data.data.meta.last_page);
				})
				.catch(error => {
					console.error(`/api/v1/book-management:${error}`);
				})
			}
		})
		.catch(error => {
			console.error(`sanctumError:${error}`);
		})
	}
	useEffect(() => {
		getBookRequest();
	}, [correntPageState, sortState])

	if(isFirstRender.current === true){
		return(
			<div className="flex flex-col">
				<SortBar changeSortState={changeSortState} />
				<SearchBar changeSearchState={changeSearchState} getBookRequest={getBookRequest} />
				<AdminBookTableLent lists={bookListState}/>
				<Pagenation pageCount={pageCountState} setCorrentPageState={setCorrentPageState} />
			</div>
		);
	}
	else {
		return(
			<div>Now Loading</div>
		);
	}
}
export { AdminBookLentList };