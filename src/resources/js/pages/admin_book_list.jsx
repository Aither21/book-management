import { React, useState, useEffect, useRef } from "react";
import axios from "axios";
import { AdminBookTableReturn } from '../components/admin_book_table_return';
import { AdminBookTableLent } from '../components/admin_book_table_lent';
import { AdminBookTableAll } from '../components/admin_book_table_all';
import { AdminSidePanel } from "../components/admin_side_panel";

const AdminBookList = () => {
	const [bookListState, setBookListState] = useState({});
	const [displayState, setDisplayState] = useState('LENT');
	const isFirstRender = useRef(false);
	useEffect(() => {
		isFirstRender.current = true;
	}, [displayState])

	const getBookRequest = async () => {
		await axios.get('/sanctum/csrf-cookie').then((data) => {
			const sanctumStatus = data.status;
			console.log(sanctumStatus)
			if(sanctumStatus !== 204){
				location.href='/login';
			}
			else {
				axios.get("/api/v1/book-management")
				.then(data => {
					console.log(data.status)
					setBookListState(data.data.data);
				})
				.catch(data => {
				})
			}
		})
		.catch((data) => {
		})
	}
	useEffect(() => {
		getBookRequest();
		// console.log(bookListState);
	}, [])

	const changeStateLent = () => {
		setDisplayState('LENT');
	}
	const changeStateReturn = () => {
		setDisplayState('RETURN');
	}
	const changeStateAll = () => {
		setDisplayState('ALL');
	}
	console.log(isFirstRender)

	if(isFirstRender.current === true){
		switch(displayState){
			case 'LENT':
				return(
					<div className="flex">
						<AdminSidePanel display={displayState} returnButton={changeStateReturn} allButton={changeStateAll}/>
						<AdminBookTableLent lists={bookListState} />
					</div>
				);
				break;
				
			case 'RETURN':
				return(
					<div className="flex">
						<AdminSidePanel display={displayState} lentButton={changeStateLent} allButton={changeStateAll}/>
						<AdminBookTableReturn lists={bookListState} />
					</div>
				);
				break;
					
			case 'ALL':
				return(
					<div className="flex">
					<AdminSidePanel display={displayState} lentButton={changeStateLent} returnButton={changeStateReturn}/>
					<AdminBookTableAll lists={bookListState} />
				</div>
				);
				break;
		}
	}
	else {
		return(
			<div>Now Loading</div>
		);
	}
}
export { AdminBookList };