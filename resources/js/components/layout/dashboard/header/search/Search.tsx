'use client'

import { useLayoutStore } from '@/stores'
import { Command, Search as SearchIcon } from 'lucide-react'
import { Fragment, MouseEvent } from 'react'
import SearchCommand from './search-command'

const Search = () => {
    const { toggleCommand } = useLayoutStore((state) => state)

    const handleCommand = (event: MouseEvent<HTMLButtonElement>) => {
        event.preventDefault()

        toggleCommand(true)
    }

    return (
        <Fragment>
            <SearchCommand />
            <button
                type="button"
                onClick={handleCommand}
                className="border-input text-muted-foreground selection:text-accent-foreground hover:bg-muted/40 hover:border-muted-foreground/30 relative flex h-9 grow cursor-pointer items-center justify-between gap-6 rounded-md border bg-transparent py-1 pr-1.5 pl-3 text-sm shadow-xs transition-colors md:min-w-72 md:grow-0"
            >
                <div className="flex items-center gap-2">
                    <SearchIcon className="size-3.5" />
                    <span>Search for anything</span>
                </div>

                <div className="bg-accent hidden gap-1 rounded-sm px-1.5 py-1 text-white md:flex">
                    <Command className="size-3.5" />
                    <span className="text-xs"> + K</span>
                </div>
            </button>
        </Fragment>
    )
}

export default Search
